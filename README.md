# Display Pattern Lab

## Installation

### Mac
If working with a Mac, make sure you have installed the latest version of:

* Vagrant (https://www.vagrantup.com/downloads.html)
* Virtualbox (https://www.virtualbox.org/wiki/Downloads)

This will provide you with a virtual machine that runs a docker deamon and maps the display pattern lab to the same directory as on the host:

    vagrant up // might ask for root password
    vagrant ssh
    cd /path/to/directory/as/on/your/mac/display-pattern-lab


### Local docker (linux native)  
Alternatively you can just use a local docker deamon, e.g. when working with a linux.

Then start the lab as follows:

    ./docker/install // only necessary after first checkout or changes to depencencies
    ./docker/start

### No Docker  
If you do not like docker for any reason and love to pollute your host machine with dependencies make sure you have installed:
 
* node >= 5.0.0 (https://nodejs.org/en/download/)
* composer (https://getcomposer.org/download/)

Then initialize and run the project like this:

    composer install
    npm install
    npm install vendor/chefkoch/display-patterns
    node_modules/.bin/gulp