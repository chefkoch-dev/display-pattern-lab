Vagrant.configure("2") do |config|
  # always use Vagrants insecure key
  config.ssh.insert_key = false

  config.vm.box = "coreos-stable"
  config.vm.box_version = "899.15.0"
  config.vm.box_url = "https://storage.googleapis.com/stable.release.core-os.net/amd64-usr/899.15.0/coreos_production_vagrant.json"

  config.vm.provider :virtualbox do |v|
    v.check_guest_additions = false
    v.functional_vboxsf     = false
  end

  if Vagrant.has_plugin?("vagrant-vbguest") then
    config.vbguest.auto_update = false
  end

  config.vm.hostname = "display-pattern-lab"

  config.vm.provider :virtualbox do |vb|
    vb.gui = false
    vb.memory = 1024
    vb.cpus = 1
  end

  config.vm.network :private_network, ip: "172.123.123.123"

  currentDirectory=File.dirname(__FILE__)
  config.vm.synced_folder currentDirectory, currentDirectory, id: "display-pattern-lab", :nfs => true, :mount_options => ['nolock','rw', 'vers=3', 'tcp','fsc','actimeo=2']
end