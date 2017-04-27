# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "centos_php70.box"
  config.ssh.password = "vagrant"
  config.vm.box_url = "http://files.gcdtech.com/vagrant/centos_php70.box"
  config.vm.provision "shell", :path => "vagrant/provision.sh"

  config.vm.network "forwarded_port", guest: 80, host: 8081
  config.vm.network "forwarded_port", guest: 3306, host: 3307

end
