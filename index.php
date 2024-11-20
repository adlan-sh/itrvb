<?php

class Product
{
    private readonly int $id;

    private readonly string $name;

    private readonly float $price;

    private string $description;

    public function __construct(int $id, string $name, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}

class Cart
{
    private array $items = [];

    public function addItem(Product $item, int $count): self
    {
        $this->items[$item->getName()] = [
            'item' => $item,
            'count' => $count
        ];

        return $this;
    }

    public function deleteItem(Product $item, int $count): self
    {
        if (in_array($item, $this->items, true) && $this->items[$item->getId()]['count'] >= $count) {
            $this->items[$item->getId()]['count'] -= $count;
        }

        return $this;
    }
}

class User
{
    private readonly string $login;

    private readonly string $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getLogin(): string
    {
        return $this->login;
    }
}

class Review
{
    private User $user;

    private int $scale;

    private string $text;

    public function __construct(User $user, int $scale, string $text)
    {
        $this->user = $user;
        $this->scale = $scale;
        $this->text = $text;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getScale(): int
    {
        return $this->scale;
    }

    public function setScale(int $scale): self
    {
        $this->scale = $scale;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}

class Form
{
    private string $title;

    private string $buttonText;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getButtonText(): string
    {
        return $this->buttonText;
    }

    public function setButtonText(string $buttonText): self
    {
        $this->buttonText = $buttonText;

        return $this;
    }
}

class FeedbackForm extends Form
{
    private User $user;

    private int $score;

    private string $text;

    public function __construct(string $title, User $user, int $score, string $text)
    {
        parent::__construct($title);
        $this->user = $user;
        $this->score = $score;
        $this->text = $text;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $scale): self
    {
        $this->score = $scale;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
