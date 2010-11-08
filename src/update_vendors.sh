#!/bin/sh

CURRENT=`pwd`/vendor

# Doctrine ORM
cd $CURRENT/doctrine && git pull

# Doctrine Data Fixtures Extension
cd $CURRENT/doctrine-data-fixtures && git pull

# Doctrine DBAL
cd $CURRENT/doctrine-dbal && git pull

# Doctrine common
cd $CURRENT/doctrine-common && git pull

# Swiftmailer
cd $CURRENT/swiftmailer && git pull

# Symfony
cd $CURRENT/symfony && git pull

# Twig
cd $CURRENT/twig && git pull

# Zend Framework
cd $CURRENT/zend && git pull

# DoctrineExtensions
cd $CURRENT/doctrine-extensions && git pull
