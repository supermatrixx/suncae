#!/bin/bash -e

# TODO: --force flag

if [ ! -e deps.sh ]; then
  echo "run deps.sh from the root directory, i.e."
  echo "\$ ./deps.sh"
  exit 1
fi

# check for needed tools
for i in wget tar unzip patchelf python3; do
  if [ -z "$(which $i)" ]; then
    echo "error: ${i} not installed"
    exit 1
  fi
done

if [ ! -d data ]; then
  mkdir -p data
  chmod 0777 data
fi

mkdir -p deps

# TODO: --force
# TODO: parse conf.php
. renderers/x3dom/deps.sh
. uxs/faster-than-quick/deps.sh
. meshers/gmsh/deps.sh
. solvers/feenox/deps.sh


# $ cd ~/public_html
# $ php -S localhost:8000
# http://localhost:8000/

# for apache, make sure all the parents have 755
# sudo apt-get install apache2 libapache2-mod-php8.2 php-yaml


# https://befonts.com/downfile?post_id=435326&post_slug=flama-font-family&pf_nonce=66a9899d9e
# https://dwl.freefontsfamily.com/download/flama-font-free-download/?wpdmdl=36256&refresh=65d0ff7ea21c01708195710
