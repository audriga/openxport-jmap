<?php

namespace OpenXPort\Jmap\Files\Methods;

use OpenXPort\Jmap\Core\Methods\SetMethod;
use OpenXPort\Jmap\Files\FileNode;

class FileNodeSetMethod extends SetMethod
{
    public function handle($methodCall, $dataAccessors, $dataAdapters, $dataMappers)
    {
        $arguments = $methodCall->getArguments();
        $methodName = $methodCall->getName();
        $adapter = $dataAdapters["FileNodes"];
        $mapper = $dataMappers["FileNodes"];
        $created = [];
        $updated = [];
        $destroyed = [];

        // Handle create operations
        if (isset($arguments["create"]) && !is_null($arguments["create"])) {
            $filesToCreate = $arguments["create"];

            foreach ($filesToCreate as $creationId => $fileData) {
                try {
                    $fileNode = FileNode::fromJson($fileData);
                    $fileNodeMap = $mapper->mapFromJmap([$creationId => $fileNode], $adapter);

                    $createdFiles = $dataAccessors["FileNodes"]->create($fileNodeMap);
                    $created = array_merge($created, $createdFiles);
                } catch (\Exception $e) {
                    error_log("Failed to create file node $creationId: " . $e->getMessage());
                }
            }
        }

        // Handle update operations
        if (isset($arguments["update"]) && !is_null($arguments["update"])) {
            $filesToUpdate = $arguments["update"];

            foreach ($filesToUpdate as $id => $partialFileData) {
                try {
                    $existingFiles = $dataAccessors["FileNodes"]->get([$id]);

                    if (empty($existingFiles) || !isset($existingFiles[$id])) {
                        continue;
                    }

                    $existingFile = $existingFiles[$id];
                    $existingJmapFiles = $mapper->mapToJmap([$id => $existingFile], $adapter);

                    if (empty($existingJmapFiles)) {
                        continue;
                    }

                    $existingJmapFile = reset($existingJmapFiles);
                    $existingArray = json_decode(json_encode($existingJmapFile), true);
                    $updateArray = is_array($partialFileData) ? $partialFileData :
                        json_decode(json_encode($partialFileData), true);

                    $mergedArray = array_merge($existingArray, $updateArray);
                    $mergedObject = json_decode(json_encode($mergedArray));
                    $mergedFileNode = FileNode::fromJson($mergedObject);

                    $tempId = 'temp_' . md5($id);
                    $fileNodeMap = $mapper->mapFromJmap([$tempId => $mergedFileNode], $adapter);

                    $remappedFileMap = [];
                    if (!empty($fileNodeMap)) {
                        $firstElement = reset($fileNodeMap);
                        $fileData = reset($firstElement);
                        $remappedFileMap[$id] = $fileData;
                    }

                    $updatedFiles = $dataAccessors["FileNodes"]->update($remappedFileMap);

                    if (isset($updatedFiles[$id]) && $updatedFiles[$id] === true) {
                        $updated[$id] = (object)[];
                    }
                } catch (\Exception $e) {
                    error_log("Failed to update file node $id: " . $e->getMessage());
                }
            }
        }

        // Handle destroy operations
        if (isset($arguments["destroy"]) && !is_null($arguments["destroy"])) {
            try {
                $destroyed = $dataAccessors["FileNodes"]->destroy($arguments["destroy"]);
            } catch (\Exception $e) {
                error_log("Failed to destroy file nodes: " . $e->getMessage());
            }
        }

        return $this->buildMethodResponse($created, $destroyed, $methodCall, $updated);
    }
}
