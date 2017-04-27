<?php

namespace HackTheHub;


use HackTheHub\Custard\HackTheHubCustard;
use HackTheHub\Layouts\DefaultLayout;
use HackTheHub\Leaves\Event\EventCollection;
use HackTheHub\Leaves\Event\EventCollectionView;
use HackTheHub\Leaves\Index;
use HackTheHub\Leaves\RestResource\EventResource;
use HackTheHub\LoginProviders\HackTheHubLoginProvider;
use HackTheHub\Models\HackTheHubSolutionSchema;
use Rhubarb\Crown\Application;
use Rhubarb\Crown\Encryption\HashProvider;
use Rhubarb\Crown\Encryption\Sha512HashProvider;
use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Crown\String\StringTools;
use Rhubarb\Crown\UrlHandlers\ClassMappedUrlHandler;
use Rhubarb\Leaf\Crud\UrlHandlers\CrudUrlHandler;
use Rhubarb\Leaf\LeafModule;
use Rhubarb\RestApi\Resources\ApiDescriptionResource;
use Rhubarb\RestApi\UrlHandlers\RestApiRootHandler;
use Rhubarb\RestApi\UrlHandlers\RestCollectionHandler;
use Rhubarb\Scaffolds\AuthenticationWithRoles\AuthenticationWithRolesModule;
use Rhubarb\Stem\Custard\SeedDemoDataCommand;
use Rhubarb\Stem\Repositories\MySql\MySql;
use Rhubarb\Stem\Repositories\Repository;
use Rhubarb\Stem\Schema\SolutionSchema;
use Rhubarb\Stem\StemModule;

class HackTheHub extends Application
{
    protected function initialise()
    {
        parent::initialise();

        if (file_exists(APPLICATION_ROOT_DIR . "/settings/site.config.php")) {
            include_once(APPLICATION_ROOT_DIR . "/settings/site.config.php");
        }

        $this->developerMode = true;

        Repository::setDefaultRepositoryClassName(MySql::class);

        SolutionSchema::registerSchema('HackTheHubSchema', HackTheHubSolutionSchema::class);

        HashProvider::setProviderClassName(Sha512HashProvider::class);
    }

    protected function registerUrlHandlers()
    {
        parent::registerUrlHandlers();

        $this->addUrlHandlers(
            [
                '/api/' => $apiHandler = new RestApiRootHandler(
                    ApiDescriptionResource::class, [
                        'events' => new RestCollectionHandler(EventResource::class)
                    ]
                ),
                "/" => new ClassMappedUrlHandler(Index::class, [
                    'event/' => new CrudUrlHandler('Event', StringTools::getNamespaceFromClass(EventCollection::class))
                ])
            ]
        );
    }

    protected function getModules()
    {
        return [
            new LayoutModule(DefaultLayout::class),
            new StemModule(),
            new LeafModule(),
            new AuthenticationWithRolesModule(HackTheHubLoginProvider::class, '/admin/'),
        ];
    }

    public function getCustardCommands()
    {
        SeedDemoDataCommand::registerDemoDataSeeder(new HackTheHubCustard(''));

        return parent::getCustardCommands();
    }
}