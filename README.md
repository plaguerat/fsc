#PHP FSC (Flux Store Creator)

Create a new React flux store including the typical files:
- Action
- API
- Constants
- Store

I got tired of having to copy/paste boilerplate to stores every time I added one.
Now I run the command and the files are created with sensible default templates.

Yes, I'm using PHP to create stuff for React/flux. It was the quickest way for me
to churn something out

####Dependencies

Requires PHP >=5.4

####Installation
__Option 1:__ Download the PHAR archive.
__Option 2:__ Download the entire repo and build.

####Usage

`php /path/to/flux-create-store.phar --store <storename> --storepath /path/to/store`

__Note:__ Currently you __must__ use an absolute path

####@TODO

- Tests
- Add to packagist
- Help command
- Relative path
- Port to node shell command
