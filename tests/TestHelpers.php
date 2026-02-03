<?php

namespace Tests;

use App\Models\User;
use App\Models\Category;

/**
 * Helper trait for test context properties
 * 
 * @property User $user
 * @property Category $category
 */
trait TestHelpers
{
    // This trait is used to help static analyzers understand
    // the properties that are dynamically bound in Pest tests
}
