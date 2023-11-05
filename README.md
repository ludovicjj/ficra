# Ficra

## Project

* PHP 8.1
* Symfony 6.3.*
* Doctrine
* Docker


## Etude de cas

* soft delete
* Chain provider
* Table inheritance


### Table inheritance

#### Setup

Implémentons cette stratégie. La class User doit être abstraite et avoir les annotations suivantes :

```php
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap(['collaborator' => Collaborator::class, 'partner' => Partner::class])]
abstract class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(type: 'string')]
    protected ?string $firstName;

    #[ORM\Column(type: 'string')]
    protected ?string $lastname;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected ?string $email;

    #[ORM\Column(type: 'json')]
    protected array $roles = [];

    #[ORM\Column(type: 'string')]
    protected string $password;
    
    // getter && setter
}
```

#### Class Collaborator
```php
#[ORM\Entity(repositoryClass: CollaboratorRepository::class)]
class Collaborator extends User
{

}
```

#### Class Partner
```php
#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner extends User
{

}
```

Nous indiquons :

Le type d'héritage : ```JOINED```, cela indique à Doctrine la stratégie à utiliser.
La colonne qui identifie le type d'utilisateur : ```discr```
les valeurs possibles du type d'utilisateur : ```Collaborator``` ou ```Partner```. 

Au niveau de la base de données, cela se traduira par 3 tables : user, partner et collaborator, chacune possédant les informations de leurs classes respectives. Les tables partner et collaborator seront liées à la table user via une clé étrangère (en général, cela sera la clé primaire id qui sert de clé étrangère.).

### Chain provider

C'est dans ```config/packages/security.yaml``` que cela se passe :

```yaml
    providers:
        app_collaborator_provider:
            entity:
                class: App\Entity\Collaborator
                property: 'email'
        app_partner_provider:
            entity:
                class: App\Entity\Partner
                property: 'email'
        chain_provider:
            chain:
                providers: ['app_collaborator_provider', 'app_partner_provider']
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: chain_provider
```

### Soft Delete

installation :
```yaml
composer require gedmo/doctrine-extensions
```

Mise à jour de la configuration Doctrine ```config/doctrine.yaml```
```yaml
doctrine:
    dbal:
    # your dbal config here
    orm:
        auto_generate_proxy_classes: '%kernel.debug%'
        auto_mapping: true
        # only these lines are added additionally
        filters:
            softdeleteable:
                class: Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter
```

Ajout des listeners dans ```services.yaml```
```yaml
services:
    # Doctrine Extension listeners to handle behaviors
    gedmo.listener.softdeleteable:
        class: Gedmo\SoftDeleteable\SoftDeleteableListener
        tags:
            - { name: doctrine.event_listener, event: 'onFlush' }
            - { name: doctrine.event_listener, event: 'loadClassMetadata' }
        calls:
            - [ setAnnotationReader, [ "@annotation_reader" ] ]
```
