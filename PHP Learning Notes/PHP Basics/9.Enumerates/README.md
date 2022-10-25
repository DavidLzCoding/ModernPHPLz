# Enumerations

Enumerations, or "Enums" allow a developer to define a custom type that is limited to one of a discrete number of possible values. That can be especially helpful when defining a domain model, as it enables "making invalid states unrepresentable."

In PHP, Enums are a special kind of object. The Enum itself is a class, and its possible cases are all single-instance objects of that class. That means Enum cases are valid objects and may be used anywhere an object may be used, including type checks.


For example:

```php
<?php
enum Suit
{
    case Hearts;
    case Diamonds;
    case Clubs;
    case Spades;
}
?>
```