Chirripo Proxy
==============

Proxy for [Chirripo](https://github.com/chirripo/chirripo)

# Instructions

- Install either globally (`composer global require chirripo/chirripo-proxy`) or by using cgr ([https://packagist.org/packages/consolidation/cgr](https://packagist.org/packages/consolidation/cgr))
- Now the chirripo-proxy binary is available globally. Make sure your global vendor binaries directory is in your $PATH environment variable, you can get its location with the following command:
```
php composer.phar global config bin-dir --absolute
```
- Start proxy: `chirripo-proxy up`
- Stop proxy: `chirripo-proxy down`
- Set your project `VIRTUAL_HOST` variable to the base url variable
- Add VIRTUAL_HOST value to your hosts config like this (/etc/hosts for Linux & Mac):

```
127.0.0.1 chirripo.docker varnish.chirripo.docker mailhog.chirripo.docker solr.chirripo.docker
```