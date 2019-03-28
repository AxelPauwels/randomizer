config/database.php -> rename the file (remove "default") and fill connection data in
config/routes.php -> rename the default controller at the bottom 
config/config.php -> rename base_url (and index_page when renaming index.php)
/.htaccess -> rename rewrite url

**Extra: Entities**
There's a "entity-setup" example "Game"
When adding a dockBlock in the view you can use the getters to autocomplete your public functions
Example :
/**
* @var Game_entity $game
*/
<p> <?php echo $game->getTitle(); ?> </p>

**Extra: Less**
There's a "less-setup"
You can use less files, importing, mixins, variables etc. Final less file is "custom.less"

**Extra: Fontface mixin**
You can easily add fonts by using the mixin