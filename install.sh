sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get update
sudo apt-get install libapache2-mod-php7.2 -y
sudo a2dismod php7.0
sudo a2enmod php7.2
sudo apt-get install php7.2-dom -y
sudo apt-get install php7.2-mbstring -y
sudo apt-get install php7.2-zip -y
sudo apt-get install php7.2-mysql -y