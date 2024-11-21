# SunCAE: Simulations in your browser

![](doc/logo.svg)

> A free and open source web-based platform for performing CAE in the cloud.

## Quickstart

You can use SunCAE either by...

 1. using someone else’s servers and configurations

     * open [this link to use SunCAE in our live demo](https://www.caeplex.com/suncae)
     * check out these Youtube videos to learn how to use it
       - [Tutorial #1: Overview](https://youtu.be/MYl7-tcCAfE) (4 min)
       - [Tutorial #2: NAFEMS LE10](https://youtu.be/ANQX0EZI_q8) (4 min)

 2. hosting your own server (it can be your laptop!) so you (or other people) can use it:

     1. install some common dependencies
     2. clone the SunCAE repository
     3. run a script to fetch the open source CAE-related tools (renderers, solvers, meshers, etc.):

        ```terminal
        sudo apt-get install git
        git clone https://github.com/seamplex/suncae
        cd suncae
        sudo apt-get install unzip patchelf wget php-cli php-yaml gnuplot
        ./deps.sh
        php -S localhost:8000 -t html
        ```
     4. open <http://localhost:8000> with a web browser

> [!NOTE]
> SunCAE is aimed at the cloud. The cloud likes Unix (and Unix likes the cloud).
> So these instructions apply to Unix-like servers, in particular GNU/Linux.
> There might be ways to run SunCAE on Windows, but we need time to figure out what they are.
>
> Moreover, most CAE solvers do not perform in Windows.
> There is a simple explanation: (good) solvers are written by hackers.
> And hackers---as [Paul Graham already explained more than twenty years ago](https://paulgraham.com/gh.html)---do not like Windows (and Windows do not like hackers either).


For more detailed instructions including setting up production web servers and using virtualization tools (e.g. docker and/or virtual machines) read the [installation guide](doc/INSTALL.md).

## Configuration

With SunCAE---as with sundae ice creams---you get to choose the toppings:

 1. [authenticators](auths) (e.g. single-user)
 2. [UXs](uxs) (e.g. faster-than-quick)
 3. [CAD importers](cadimporters) (e.g. upload)
 4. [Meshers](meshers) (e.g. gmsh)
 5. [Solvers](solvers) (e.g. feenox)
 6. Runners (to be done, e.g. local, ssh, aws, ...)
 7. Post processors (to be done, e.g. paraview, glvis, ...)


## Features

 * Free and open source. Free both as in "free beer" and in "free speech"
 * Mobile-friendly
 * Cloud-first

## Support

 * Tutorials (To be done)
 * FAQs (To be done)
 * [Forum](https://github.com/seamplex/suncae/discussions/)
 
## Licensing

The content of this SunCAE repository is licensed under the terms of the [GNU Affero General Public License version 3](https://www.gnu.org/licenses/agpl-3.0.en.html), or at your option, any later version (AGPLv3+). 

This means that you get the four essential freedoms, so you can

 0. Run SunCAE as you seem fit (i.e. for any purpose).
 1. Investigate the source code to see how SunCAE works and to change it (or to hire someone to change it four you) as you seem fit (i.e. to suit your needs)
 2. Redistribute copies of the source code as you seem fit (i.e. to help your neighbor)
 3. Publish your changes (or the ones that the people you hired made) to the public (i.e. to benefit the community).

> [!IMPORTANT]
> With great power comes great responsibility.

If you use a _modified_ version of SunCAE in your web server, [section 13 of the AGPL license](https://www.gnu.org/licenses/agpl-3.0.en.html#section13) requires you to give a link where your users can get these four freedoms as well.
That is to say, if you use a verbatim copy of SunCAE in your server, there is nothing for you to do (because the link is already provided).
But if you exercise freedoms 1 & 3 above and _modify_ SunCAE to suit your needs---let's say you don't like the button "Add Boundary Condition" and you change it to "Add restrains and loads"---you do need to provide a link for people to download the modified source code.

> [!TIP]
> If this licensing scheme does not suit you, contact us to see how we can make it work.

 * If you have a solver released under a license which is compatible with the AGPL and you would like to add it to SunCAE, feel free to fork the repository (and create a pull request when you are done).
 * If you have a solver released under a license which is not compatible with the AGPL and you would like to add it to SunCAE, contact us.

