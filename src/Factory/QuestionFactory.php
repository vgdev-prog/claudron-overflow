<?php

namespace App\Factory;

use App\Entity\Question;
use DateTimeImmutable;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Question>
 */
final class QuestionFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Question::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->realText(50),
            'question' => $this->generateMarkdownQuestion(),
            'votes' => self::faker()->numberBetween(-500,500),
            'askedAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-1 year', 'now')),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
//             ->afterInstantiate(function(Question $question): void {
//             })
        ;
    }

    private function generateMarkdownQuestion(): string
    {
        $templates = [

            sprintf(
                "%s\n\n```php\n%s\n```\n\n%s",
                self::faker()->paragraph(),
                "// Some code example\n" . self::faker()->sentence(),
                self::faker()->paragraph()
            ),

            sprintf(
                "%s\n\n- %s\n- %s\n- %s\n\n%s",
                self::faker()->paragraph(),
                self::faker()->sentence(),
                self::faker()->sentence(),
                self::faker()->sentence(),
                self::faker()->paragraph()
            ),

            sprintf(
                "## %s\n\n%s\n\n**%s**",
                self::faker()->sentence(),
                self::faker()->paragraph(2),
                self::faker()->sentence()
            ),
        ];

        return self::faker()->randomElement($templates);
    }


}
