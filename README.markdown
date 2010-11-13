**Attention: Yrch! 2.0 is still at the very beginning of its development and
will not been released until Symfony2 stable release is available. If you want
to set up your site now please use Yrch! 1.0 available on 
[SourceForge](http://sourceforge.net/projects/yrch/) and migrate to v2.0 when it
will be released.**

Yrch! is a project of yahoo-like hierachised websites categories written in PHP. 
Yrch! is willing to be an international community portal that allow site(s) 
owners to inform that community of news and changes on their own web site. 
Yrch! is a project of the french society [Tolkiendil](http://www.tolkiendil.com).

## Credits and acknowledgment

Yrch! was originally created and developed by Guillaume Boddaert.

Core Team :

- Project manager : Pascal Burkhard ([Nenuial](https://github.com/Nenuial))
- Lead developper : Christophe Coevoet ([Stof](https://github.com/stof))

## Licensing

For licensing and copyright information, please see the file
LICENSE in the YRCH! distribution.

## Requisites

- Apache2 with mod_rewrite enabled
- PHP 5.3.2 or higher
    Use the web/check.php script to check if you have the needed extensions
- MySQL

## Installation

### Get Yrch!

    git clone git://github.com/Yrch/Yrch.git yrch

### Get vendors libraries

    cd src/
    ./install_vendors.sh

Note that this will retrieve the development versions from Github. You can then
update your vendors by running :
    cd src/
    ./update_vendors.sh

### Configure Yrch!

- Copy the app/config/user_config.dist.xml file to app/config/user_config.xml
- Create a database in utf8
- Put your configuration in your app/config/user_config.xml file
    (database credentials, mailer credentials...)
- Give write permissions to your Apache user on this directories (create them
if they don't exist):
    - app/cache/
    - app/logs/

### Creating your database schema

Run the following command to create all tables in the database
    php app/console doctrine:schema:create
