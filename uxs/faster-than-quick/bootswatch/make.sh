#!/bin/bash -ex

# https://bootswatch.com/help/#customization

#  *  Download the repository: git clone https://github.com/thomaspark/bootswatch.git
#  *  Install dependencies: npm install
#  *  Make sure that you have grunt available in the command line. You can install grunt-cli as described on the Grunt Getting Started page.
#  *  In /dist, modify _variables.scss and _bootswatch.scss in one of the theme directories, or duplicate a theme directory to create a new one.
#  *  Type grunt swatch:[theme] to build the CSS for a theme, e.g., grunt swatch:flatly for Flatly. Or type grunt swatch to build them all at once.
#  *  You can run grunt to start a server, watch for any changes to the SASS files, and automatically build a theme and reload it on change. Run grunt server for just the server, and grunt watch for just the watcher.

if [ ! -d bootswatch ]; then
  git clone https://github.com/thomaspark/bootswatch.git
  cd bootswatch
else
  cd bootswatch
  git pull
fi

if [ -z "$(which npm)" ]; then
  sudo apt-get install npm
fi
if [ -z "$(which grunt)" ]; then
  sudo apt-get install grunt
fi

npm install
# npm audit fix
mkdir -p dist/faster-than-quick
cp ../_bootswatch.scss ../_variables.scss dist/faster-than-quick/
grunt swatch:faster-than-quick
cp dist/faster-than-quick/bootstrap.min.css ../../css/

