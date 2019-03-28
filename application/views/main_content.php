<main role="main" class="container">
    <div class="starter-template">
        <h1>Test random person picker</h1>
        <p class="lead">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aut autem excepturi id libero molestias
            omnis recusandae rerum vel veniam! Accusamus amet aut consequuntur impedit quam quidem voluptate. Fugiat,
            repellat.
            <br> All you get is this text</p>
    </div>
    <div class="starter-template">
        <?php
        /** @var Person $person */
        foreach ($persons as $person) {
            echo $person->getName() . " " . $person->getLastname() . '<br/><br/>';
        }
        ?>
    </div>
</main>
