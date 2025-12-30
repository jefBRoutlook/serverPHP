#!/usr/bin/php
<?php
/*
Script PHP version 8.4 simples que executa o servidor embutido (PHP -S) em segundo plano. 

Observações:
- O servidor embutido é adequado para desenvolvimento, não para produção.
- O script assume que o PHP está disponível no PATH como php.
*/
  
  const CONFIG_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'config.json';
  
  const MESSAGENS = array(
        "OK"   => "Funcionando!" . PHP_EOL,      
        "nOK"  => "Estamos com problemas! Veja logs." . PHP_EOL,
        "ON"   => "Servidor está rodando!" . PHP_EOL,      
        "OFF"  => "Servidor não está rodando!" . PHP_EOL,      
        "SET"  => "Alteraçãoo feito com sucesso" . PHP_EOL,
        "nSET" => "Sintaxe correta:  php servidor.php set [atributo] [novo valor]"  . PHP_EOL, 
        "file_not_exists" => "Arquivo não existe!" . PHP_EOL,      
        "restart" => "Servidor reniciado!" . PHP_EOL,      
        "stop"    => "Servidor foi finalizado!" . PHP_EOL,
        "PAUSA"   => "Por favor aguarde!" . PHP_EOL,
        "ABOUT"   => "Uso: php servidor.php [on|off|status|set|restart|config]".PHP_EOL
  );

  function show_message(string $msg="OK"){
     echo MESSAGENS[$msg];
  };

  function show_config($cfg){
    show_message("ABOUT");
    echo "*\n* Attributo:valor \n*". PHP_EOL;
    foreach ($cfg as $k => $v) {
      echo trim( $k ).":".trim( (string) $v ). PHP_EOL;
    }
  }

  // Registro de autoload simples sem Composer
  /*
  spl_autoload_register(function ($class) {

      $path = 'src/' . str_replace('\\', '/', $class) . '.php';
      if (file_exists($path)) {
          require $path;
      }
  });
  */
  // Comando para rodar todos os teste
  // php /vendor/bin/phpunit
  // Registro de autoload com Composer 
  // - composer install
  // - composer dump-autoload
  require 'vendor/autoload.php';

  // instacia do servidor
  $serve= new Serve();

  // Validação simples de argumento
  $arg   = $argv[1] ?? '';
  $attrb = $argv[2] ?? '';
  $value = $argv[3] ?? '';

  switch (strtolower($arg)) {
      case 'test':
          /*
          var_dump( $serve->cfg );    
          $serve->set_config("PID",0);
          $serve->set_config("DOCROOT",".");
          $serve->set_config("NPORT",8090);
          $serve->save_config();
          */
          break;
      case 'set':
          show_message($serve->set($attrb,$value) ? "SET" : "nSET");
          break;
      case 'on':
          show_message($serve->on() ? "ON" : "nOK");
          break;
      case 'off':
          show_message($serve->off() ? "OFF" : "nOK");
          break;
      case 'restart':
          show_message($serve->off() ? "stop" : "nOK");
          echo "..".PHP_EOL;
          show_message("PAUSA");
          sleep(3);
          echo "..".PHP_EOL;
          show_message($serve->on() ? "ON" : "nOK");
          break;          
      case 'status':
          show_message($serve->status() ? "ON" : "OFF");
          break;
      case 'config':
          show_config($serve->cfg);    
          break;    
      default:
          show_message("ABOUT");
          break;
  }