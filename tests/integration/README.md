# Integration tests
## Usage
* Run against test instances via `ansible-playbook tests.yml`
* Run against a specific QA instance via `ansible-playbook -i hosts_qa -l <qa_instance_name> tests.yml`.

### Advanced Usage
* You can put your own local instances in an own hosts file based upon `hosts_local.sample` . Then use this via `ansible-playbook -i hosts_local tests.yml`
* Sometimes test data does weird things. If you want to use the normal user for debugging purposes run `ansible-playbook --tags normal_user tests.yml`
* If your target does not support certain verticals you can not include them in the test by skipping the tag. E.g. `ansible-playbook --skip-tags files tests.yml`
