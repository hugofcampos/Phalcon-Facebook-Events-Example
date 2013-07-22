vagrant-phalcon
===============

A Phalcon setup project using Vagrant.

Prerequisites

Vagrant 1.2.3

Virtualbox 4.2

If you're using Ubuntu 12.10 additional reconfiguration of kernel headers is required, after VirtualBox installation as following:

-- Install kernel headers linux-headers-3.5.0-17-generic
$ sudo apt-get install linux-headers-3.5.0-17-generic

-- Reconfiguration of VirtualBox

$ sudo /etc/init.d/vboxdrv setup


MySQL root password: 123456