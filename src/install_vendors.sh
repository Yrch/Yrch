#!/bin/sh

# initialization
if [ -d "vendor" ]; then
  rm -rf vendor/*
else
  mkdir vendor
fi

cd vendor

# Doctrine ORM
git clone git://github.com/doctrine/doctrine2.git doctrine

# Doctrine Data Fixtures Extension
git clone git://github.com/doctrine/data-fixtures doctrine-data-fixtures

# Doctrine DBAL
git clone git://github.com/doctrine/dbal.git doctrine-dbal

# Doctrine Common
git clone git://github.com/doctrine/common.git doctrine-common

# Swiftmailer
git clone git://github.com/swiftmailer/swiftmailer.git swiftmailer

# Symfony
git clone git://github.com/fabpot/symfony.git symfony

# Twig
git clone git://github.com/fabpot/Twig.git twig

# Twig Extensions
git clone git://github.com/fabpot/Twig-extensions.git twig-extensions

# Zend Framework
git clone git://github.com/zendframework/zf2.git zend

# DoctrineExtensions
git clone git://github.com/l3pp4rd/DoctrineExtensions.git doctrine-extensions
