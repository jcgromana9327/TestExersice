Installation of phpunit-selenium

1. create a separate folder for composer
    Commands:
        cd /data/
        mkdir composer

2. Go to composer folder
    Command:
        cd /data/composer/

3. Create a composer.json file with phpunit and selenium version
    vim composer.json
{
  "require-dev": {
    "phpunit/phpunit": "6.x.x",
    "phpunit/phpunit-selenium": "4.x.x"
  }
}

4. Run composer command on created folder /data/composer/
    Commands:
        cd /data/composer/

        sudo dnf install composer

        composer install

        (but if composer already installed)

        composer update

5. Add /data/composer/vendor/bin/ in $PATH of your bash profile
    Commands:
        vim ~/.bash_profile
    
    PATH=/data/composer/vendor/bin:$PATH:$HOME/.local/bin:$HOME/bin

    then execute source ~/.bash_profile


Installation of firefox 51

1. Download firefox 51 in /opt/ folder
    Commands:
        cd /opt/
        mkdir firefox51/
        cd firefox51
        wget https://ftp.mozilla.org/pub/firefox/releases/51.0.1/linux-x86_64/en-US/firefox-51.0.1.tar.bz2
        tar -xvf firefox-51.0.1.tar.bz2
        mv firefox/ firefox51/
        mv firefox51/* /opt/firefox51/
        

Installation of Selenium Server
1. Download selenium server on http://www.seleniumhq.org/download/
    Download on googleapis:
    Location: http://selenium-release.storage.googleapis.com/index.html?path=3.0/
        cd /data/htdocs/
        mkdir seleniumServer
        cd seleniumServer
        wget http://selenium-release.storage.googleapis.com/3.0/selenium-server-standalone-3.0.1.jar

2. Download Firefox Gecko Driver
    Download on github
    Location: https://github.com/mozilla/geckodriver/releases
        cd /data/htdocs/seleniumServer/
        wget https://github.com/mozilla/geckodriver/releases/download/v0.13.0/geckodriver-v0.13.0-linux64.tar.gz
        tar -xvf geckodriver-v0.13.0-linux64.tar.gz

3. Run the selenium jar
    Command:
        cd /data/htdocs/seleniumServer/
        java -Dwebdriver.chrome.driver=geckodriver -jar selenium-server-standalone-3.0.1.jar 
Example Command:
        cd /path/to/my/script/
        phpunit selenium.php
