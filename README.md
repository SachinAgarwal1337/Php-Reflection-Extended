# Php-Reflection-Deflector
[![Latest Stable Version](https://poser.pugx.org/skagarwal/reflection/v/stable)](https://packagist.org/packages/skagarwal/reflection) [![Total Downloads](https://poser.pugx.org/skagarwal/reflection/downloads)](https://packagist.org/packages/skagarwal/reflection) [![Latest Unstable Version](https://poser.pugx.org/skagarwal/reflection/v/unstable)](https://packagist.org/packages/skagarwal/reflection) [![License](https://poser.pugx.org/skagarwal/reflection/license)](https://packagist.org/packages/skagarwal/reflection)
<br>
Test your **Private/Protected** Methods/Properties with any testing package and with **Zero** configuration.

**New:** can now set the values for private/protected properties. See the **Available Mothods** Section for details.

# Usage
### Step 1: Install Through Composer
```php
composer require skagarwal/reflection --dev
```

### Step 2: Import the trait
Import the `SKAgarwal\Reflection\ReflectableTrait` in your `TestClass` of any package. Eg: `PhpUnit`, `PhpSpec`, `Laracasts\Integrated`.

For `PhpUnit`
```php
use SKAgarwal\Reflection\ReflectableTrait

class ModelTest extends PHPUnit_Framework_TestCase
{
  use ReflectableTrait;
}
```

And That's it. You are all set to go. :)

**Now you can do the following to test private/protected methods or properties:**

### Instantiate the Reflector
Either By using `reflect()` method like this:
```php
$randomClass = new RandomClass();
$this->reflect($randomClass);
```
**This Method is not chainable**<br>
**Note:** Its preferable to use this in `constructor` or for PhpUnit in `setUp()` method etc.

OR by using `on()` method like this:
```php
$randomClass = new RandomClass();
$this->on($randomClass)->call($method, $args = []);
```
**This method is chainable**
**Note: **This method can also be used in place of `reflect()` method. Both do the same work.

# Available Methods
#### reflect($classObj);
**Description:** Reflect the Class Object
<br>
<br>
#### on($classObj);
**Description:** Reflect the Class Object. This is Chainable Method.<br>
Possible Chaining:
```php
$this->on($classObject)->callMethod($arguments = []);
$this->on($classObject)->call($method, $arguments = []);
$this->on($classObject)->get($property);
$this->on($classObject)->get{Proerty};
```
<br>
<br>
#### call($method, $arguments = []);
**Description:** Call any valid public/Private/Protected Method of reflected Class Object. This is not Chainable Method.
<br>
<br>
#### call{Method}($arguments = []);
**Description:** Same as `call()` but dynamically calls the method. This is not Chainable Method.<br>
{method} Can be any valid public/private/protected method of reflected Class Object.
<br>
<br>
#### get($property);
**Description:** Get the value of any valid Public/Private/Protected property of the reflected Class Object. This is not Chainable Method.
<br>
<br>
#### get{Property};
**Description:** Same as `get()` but dynamically gets the value of the property. This is not Chainable Method.<br>
{property} Can be any valid Public/Private/Protected property of the reflected Class Object.
<br>
<br>
#### set($name, $value);
**Description:** Set the value of valid Public/Private/Protected property of the reflected Class Object. This is not Chainable Method.
<br>
<br>
#### set{Property} = $value;
**Description:** Same as `set()` but dynamically sets the value of the property. This is not Chainable Method.<br>
{property} Can be any valid Public/Private/Protected property of the reflected Class Object.