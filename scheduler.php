<?php

while (true) {
    echo "Executando tarefas agendadas:";
    exec('/opt/homebrew/Cellar/php/8.2.11/bin/php /Applications/XAMPP/xamppfiles/htdocs/laravel/familia_aziz/artisan schedule:run >> /dev/null 2>&1');
    sleep(5); // Aguarde um minuto antes da próxima execução
}
