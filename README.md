## Exercise 1: Creating Simple Entity

### Acceptance Criteria
- Schema
    - accountNumber - required|string
    - subscriptionType - required|in:monthly,lifetime

### Dev Notes
- Follow how App\Database\Entities\User entity has been created.
- Make sure to add tests
- Create a PR after, this will be reviewed by any member of the group

## Exercise 2: Create Simple Repository
### Acceptance Criteria
- Create ``\App\Repositories\AccountRepositoryInterface``
- AccountRepositoryInterface should extend AppRepositoryInterface
- add ``findBySubscriptionType(string $subscriptionType): array``
- Throw a runtime exception (App\Exceptions\InvalidSubscriptionTypeException) 
if subscription type does not belong to either ``monthly / lifetime``
- Implement ``\App\Repositories\AccountRepositoryInterface``

### Dev Notes
- **Important**: Use `custom query builder` *not* a repository method
- Add functional test for AccountRepository
- Use UserRepository as a guide 
- Package used `loyaltycorp/easy-repository`
- To complete the exercise, standard checks should pass by running
    - composer ecs // Will run EasyCodingStandards 
    - composer phpstan // Will run PHPStandards
    - ./vendor/bin/phpunit or ./vendor/bin/paratest -p8 // Will run your tests


