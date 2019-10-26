# Resolucao

## Instalação

Clonar este repositório. Então rodar `composer install`. Abrir o arquivo `.env` e preencher as informações da conexão do banco de dados e então restaurar a estrutura do banco de dados que está no arquivo `database.sql`.

Para executar, basta utilizar o comando do php `php -S localhost:9000` e entrar na url [http://localhost:9000](http://localhost:9000).

## Tests

Os testes podem ser executados utilizando o comando `./vendor/bin/phpunit --bootstrap ./config.php ./tests/`.

## Misc

Escolhi não utilizar nenhum framework para não complicar demais o que já era muito simples, então utilizei apenas uma estrutura simplificada para atender o requisitado.

Qualquer dúvida fico a disposição para perguntas.
---

#### Tecnologias a Utilizar
É importante referir que fica ao teu critério, dentro das tecnologias indicadas, a escolha das ferramentas mais adequadas para resolver o problema proposto - por exemplo não há nenhuma imposição relativamente ao uso de uma framework (PHP, JS ou CSS).
No final podes enviar um ZIP com o projeto ou um link para um repositório (não esquecer o SQL para criar a BD).

- PHP7
- Javascript
- HTML
- CSS
- MySQL/SQLite/MariaDB
         
#### Look&Feel da Aplicação
- O HTML utilizado para a calculadora deve ter valor semântico (e.g. não usar `DIV` quando se deveria usar `BUTTON`) 
- Relativamente a CSS uma framework tipo [Bootstrap](https://getbootstrap.com) é suficiente. Não é necessário mais do que isso.
             
#### Elementos 
- Um mostrador 
- 10 botões com os números `0` a `9`
- 5 botões com as operações básicas (`+`, `-`, `*`, `/`, `MOD`)
- 1 botão de `reset` que limpa o mostrador
- 1 botão para realizar a operação `=`
- 1 botão `,` ou `.` para adicionar casas decimais

#### Modo de Funcionamento 
1. Quando o utilizador carrega num botão o seu valor correspondente (excepto o igual) é concatenado ao mostrador 
2. Quando o utilizador carrega no botão de realizar a operação é feito um pedido AJAX para o servidor PHP com o valor que estiver naquele momento no mostrador 
3. O script PHP calcula o valor da operação e retorna o resultado em formato JSON 
4. O resultado é colocado no mostrador substituindo o que estava lá anteriormente. Este valor acumula até o utilizador carregar no reset. 
5. Se o resultado for igual a um número aleatório gerado a cada pedido, juntamente com o resultado, deve ser devolvida uma mensagem para mostrar ao utilizador 
6. Cada pedido de operação deve ser registado numa base de dados com o schema indicado no ponto seguinte

#### Schema


```
>> id          int auto increment 
>> ip		   varchar 
>> timestamp   int (nota: unix timestamp) 
>> operation   varchar (nota: armazenar a operação completa e.g. 1 + 1 / 2 * 5) 
>> result      decimal(12,4) 
>> bonus       boolean/tinyint (nota: indicar se o resultado da operação acertou no número aleatório) 
```
      
#### Workflow 
1. Clique no botão `1`
2. Concatenar ao mostrador o número 1. O mostrador mostra `1`
3. Clique no botão `2`
4. Concatenar ao valor do mostrador o número 2. O mostrador mostra `12`
5. Clique no botão `+`
6. Concatenar ao valor do mostrador o +. O mostrador mostra `12+`
7. Clique no botão `2`
8. Concatenar ao valor do mostrador o número 2. O mostrador mostra `12+2`
9. Clique no botão `=` faz pedido AJAX para o script PHP
10. O servidor processa a operação pedida, coloca os valores necessários na base de dados e envia o resultado em JSON para o cliente. Se houver `bonus` esse valor deve também ser retornado para o frontend e mostrar a mensagem correspondente ao utilizador
11. Colocar o resultado retornado pelo script no mostrador. O mostrador mostra apenas `14`
12. Voltar ao Passo 1. Não esquecer que o valor acumula portanto o utilizador pode carregar logo no `+` e ficar `14 + ...`

#### Casos de Teste / Exemplos

`1 + 2 * 3 = 9`

`1 - 1 * 1 + 3 = 3`

-------------------------------------------

`2 / 2 * 3 + 1 - 1 = 3`

```
1º: 2 / 2 = 1
2º: 1 * 3 = 3
3º: 3 + 1 = 4
4º: 4 - 1 = 3

Resultado: 3 
```

-------------------------------------------

`5 + 3 * 5 = 40`

```
1º: 5 + 3 = 8
2º: 8 * 5 = 40
 
Resultado: 40
```

-------------------------------------------

`5 + 1 MOD 2` 

```
1º: 5 + 1 = 6
2º: 6 MOD 2 = 0
 
Resultado: 0
```

`5 + 1 MOD 5 / 0`

```
1º: 5 + 1 = 6
2º: 6 MOD 5 = 1
3º:  1 / 0 = ERRO
 
Resultado: ERRO
```

#### Edge Cases
No algoritmo de cálculo se for detectada uma divisãoo por `0` (zero), deverá ser retornado erro imediatamente em vez de dar erro PHP
             
#### Notas Importantes 
1. Não usar eval (ou truques equivalentes) para o cálculo em PHP 
2. Não é necessário avaliar expressões complexas com parêntesis (exemplos de operações válidas: `1 + 1`, `5 + 3 * 5`, `1 + 1 / 2`). No caso de operações como `5 + 3 * 5` não é necessário executar primeiro a multiplicação. Neste caso o processamento da operação seria: 1º `5 + 3` » 2º `8 * 5` » 3º `40`