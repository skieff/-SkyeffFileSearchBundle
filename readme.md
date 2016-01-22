##Installation

1 Add new repository source to composer.json

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:skieff/-SkyeffFileSearchBundle.git"
    }
]
```

2 Add package dependency

```
"require": {
    "skyeff/file-search-bundle": "dev-master"
}
```

3 Update composer dependencies 

```
>php composer.phar update
```

4 Register bundle routes in `app\config\routing.yml`

```
find_files:
    resource: "@SkyeffFileSearchBundle/Controller"
    type:     annotation
```