В уже созданных маршрутах попробуйте вызывать их с некорректными данными. Что будет происходить? Будут ли появляться ошибки?

При появлении ошибок, произведите их анализ. Обязательно зафиксируйте шаги своих размышлений.

1: Некорректное имя контроллера (спецсимволы)
// URL: /my-controller!@/index
$_SERVER['REQUEST_URI'] = '/my-controller!@/index';
$app = new Application();
$result = $app->run();
echo "Результат 1: " . $result . "\n"; 
// Ожидаемый результат: "Недопустимые символы в имени контроллера"
Код проверяет имя контроллера на наличие недопустимых символов.

2: Некорректное имя метода (спецсимволы)
// URL: /page/my-method!!$
$_SERVER['REQUEST_URI'] = '/page/my-method#$';
$app = new Application();
$result = $app->run();
echo "Результат 2: " . $result . "\n"; 
// Ожидаемый результат: "Недопустимые символы в имени метода"
Код проверяет имя метода на наличие недопустимых символов

3: Несуществующий контроллер
// URL: /nonexistent/index
$_SERVER['REQUEST_URI'] = '/nonexistent/index';
$app = new Application();
$result = $app->run();
echo "Результат 3: " . $result . "\n"; 
// Ожидаемый результат: "Класс Geekbrains\Application1\Domain\Controllers\NonexistentController не существует"
Проверка, существует ли класс контроллера

4: Несуществующий метод
// URL: /page/nonexistent
$_SERVER['REQUEST_URI'] = '/page/nonexistent';
$app = new Application();
$result = $app->run();
echo "Результат 4: " . $result . "\n"; 
// Ожидаемый результат: "Метод не существует"
Код проверяет, существует ли метод в контроллере

5: Некорректные данные для авторизации (пустой логин)
$auth = new Auth();
$result = $auth->proceedAuth("", "password");
echo "Результат 5: " . ($result ? "true" : "false") . "\n"; 
//Ожидаемый результат: false
Метод proceedAuth должен возвращать false при пустом логине

: Некорректные данные для авторизации (короткий логин)
$auth = new Auth();
$result = $auth->proceedAuth("lo", "password");
echo "Результат 6: " . ($result ? "true" : "false") . "\n"; 
//Ожидаемый результат: false
Метод proceedAuth должен возвращать false при коротком логине
