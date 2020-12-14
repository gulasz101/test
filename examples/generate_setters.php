<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$class = \Pingen\Models\CompanyInputPOSTAttributes::class;

$properties = array();
$reflectClass = new ReflectionClass($class);
foreach ($reflectClass->getProperties(ReflectionProperty::IS_PROTECTED) as $property) {
    if ($property->getDeclaringClass()->getName() === $class) {
        $properties[] = array($property->getType(), $property->getName());
    }
}
echo PHP_EOL;
echo PHP_EOL;

collect($properties)
    ->each(function (array $property) use ($class): void {
        /** @var ReflectionType $type */
        [$type, $propertyName] = $property;

        if (! $type->isBuiltin()) {
            $type = '\\' . (string) $type;
        }

        echo \Illuminate\Support\Str::of('*')
            ->append(' @method \\')
            ->append($class)
            ->append(' ')
            ->append(
                \Illuminate\Support\Str::of($propertyName)
                    ->ucfirst()
                    ->prepend('set')
                    ->camel()
                    ->append('(')
                    ->append($type)
                    ->append(' $value)')
            )
            ->append(PHP_EOL);
    });

echo '*';
echo PHP_EOL;
echo PHP_EOL;
