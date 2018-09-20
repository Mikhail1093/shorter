<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('shorter');

            /*
             * Тест нажатия кнопки для скоращения ссылки
             */
            //todo если пустое поле ссылки
            $browser->visit('/')
                ->type('link', 'https://test-site.com?test_dusk=test_' . random_int(1, PHP_INT_MAX))
                //->type('test_field', 'Y')
                ->press('Сократить')
                ->waitFor('.data-link') //Ожидание селектора с результатом сокращенной ссылки
                //todo можно ли задать регулярку для вида: http://shorter.loc/[w+], длиной симовлов, на сколько сокращаем ссылку
                ->assertSeeIn('.data-link', 'http://shorter.loc/'); //todo убрать хардкод, потому что url будет другой!!
        });
    }
}
