# Commissions test app [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ypppa/commissions/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ypppa/commissions/?branch=master)

## How to use

### Install

`composer install`

### Calculate commissions from file

`./application.php input.txt`

Expected result:
```bash
 0/5 [>---------------------------]   0% Transaction: 100 EUR   Commission: 1 EUR
 1/5 [=====>----------------------]  20% Transaction: 50 USD   Commission: 0.46 EUR
 2/5 [===========>----------------]  40% Transaction: 10000 JPY   Commission: 1.36 EUR
 3/5 [================>-----------]  60% Transaction: 130 USD   Commission: 2.39 EUR
 4/5 [======================>-----]  80% Transaction: 2000 GBP   Commission: 45.92 EUR
 5/5 [============================] 100%%

```

### Run unit tests

`php bin/phpunit tests`

### Possible errors

`[error] Got error while trying to get currencies rates` - currency rates provider is unavailable. Try later.

`[error] Got error while trying to get bin info` - bin list provider is unavailable. Try later.