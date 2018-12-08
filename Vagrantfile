# -*- mode: ruby -*-
# vi: set ft=ruby :

$script = <<SCRIPT
export DEBIAN_FRONTEND=noninteractive
echo "Adding Ondřej Surý PHP Ubuntu PPA..."
LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php -y > /dev/null 2>&1
echo "Installing packages..."
apt-get update > /dev/null 2>&1
apt-get install git mysql-server nginx php7.2-curl php7.2-fpm php7.2-gd php7.2-intl php7.2-json php7.2-mbstring php7.2-mysql php7.2-sqlite3 php7.2-xml php7.2-zip php-pear -y > /dev/null 2>&1
echo "Installing pear packages..."
pear channel-update pear.php.net > /dev/null 2>&1
pear channel-discover bartlett.laurent-laville.org > /dev/null 2>&1
pear channel-discover components.ez.no > /dev/null 2>&1
pear install bartlett/PHP_CompatInfo > /dev/null 2>&1
echo "Creating nginx config..."
echo 'server {
    listen 80;
    server_name .beehiveforum.test;
    root /home/vagrant/beehiveforum/forum;
    index index.php;
    charset utf-8;
    access_log off;
    error_log  /var/log/nginx/beehiveforum-error.log error;
    sendfile off;
    client_max_body_size 100m;
    location ~ \.php\$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(.*)\$;
        fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
    }
}' > /etc/nginx/sites-available/beehiveforum.test
ln -sf /etc/nginx/sites-available/beehiveforum.test /etc/nginx/sites-enabled/
echo "Restarting nginx..."
service nginx restart > /dev/null 2>&1
echo "Creating MySQL Database and User..."
mysql -e "CREATE DATABASE beehiveforum"
mysql -e "GRANT ALL PRIVILEGES ON beehiveforum.* TO 'beehiveforum'@'%' IDENTIFIED BY 'password'"
echo "Installing Composer..."
mkdir -p /opt/composer
wget -qO- https://getcomposer.org/installer | php -- --install-dir /opt/composer > /dev/null 2>&1
ln -sf /opt/composer/composer.phar /usr/local/bin/composer
echo "Done!"
SCRIPT

Vagrant.configure("2") do |config|

	config.vm.box = "ubuntu/bionic64"
	config.vm.hostname = "beehiveforum"
	config.vm.define "beehiveforum"
	
	config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
	config.vm.network "forwarded_port", guest: 3306, host: 33060, host_ip: "127.0.0.1"
	config.vm.network "private_network", type: "dhcp"

	config.vm.synced_folder "./", "/home/vagrant/beehiveforum"
	config.vm.provision "shell", inline: $script
	config.ssh.forward_agent = true

	config.vm.provider "virtualbox" do |vb|
		vb.name = "beehiveforum"
		vb.customize ["modifyvm", :id, "--memory", "2048"]
		vb.customize ["modifyvm", :id, "--cpus", "1"]
		vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
		vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
		vb.customize ["modifyvm", :id, "--ostype", "Ubuntu_64"]
		vb.customize ["modifyvm", :id, "--uartmode1", "disconnected"]
	end

	["vmware_fusion", "vmware_workstation"].each do |vmware|
		config.vm.provider vmware do |v|
			v.vmx["displayName"] = "beehiveforum"
			v.vmx["memsize"] = 2048
			v.vmx["numvcpus"] = 1
			v.vmx["guestOS"] = "ubuntu-64"
		end
	end

	config.vm.provider "parallels" do |v|
		v.name = "beehiveforum"
		v.update_guest_tools = false
		v.memory = 2048
		v.cpus = 1		
	end
end
