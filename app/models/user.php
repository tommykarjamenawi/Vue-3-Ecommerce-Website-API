<?php

namespace Models;

class User
{
  public int $id;
  public string $full_name;
  public string $email;
  public string $password;
  public ?string $address;
  public int $role;
  public ?string $image;
}
