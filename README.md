Запуск скрипта магазина:

`php runner.php`

Настройка исходных данных:

src/Store.class.php

Store::CASHIERS_COUNT - максимальное количество касс в магазине.
Store::WAITING_BUYERS_LIMIT - количество покупателей в магазине, для открытия новой кассы.
Store::WORK_TIME - рабочее время магазина, в секундах.

src/CashierOptions.class.php

CashierOptions::PUSH_TIME - время для обработки одного продукта, в секундах.
CashierOptions::PAY_TIME - время оплаты, в секундах.
CashierOptions::DOWNTIME_FOR_SLEEP - количество секунд ожидания перед закрытием пустой кассы.

src/BuyerService.class.php

BuyerService::GEN_INTERVAL - интервал для создания новой пачки пользователей.
BuyerService::K - коэффициент для генерации пользователей.
