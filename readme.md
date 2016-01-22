##Installation

1. Add new repository source to composer.json

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@bitbucket.org:skyeff/skyefffilesearchbundle.git"
    }
]
```

2. Add package dependency

```
"require": {
    "skyeff/file-search-bundle": "dev-master"
}
```

3. Register bundle routes in `app\config\routing.yml`

```
find_files:
    resource: "@SkyeffFileSearchBundle/Controller"
    type:     annotation
```