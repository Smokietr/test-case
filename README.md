## Hızlı Kurulum

Kullanabilmek için docker ve docker-compose kurulu olmalıdır.

```bash
  docker-compose up -d
```

Unit Test Sonuçları

```bash
  docker logs tests
```

Beklenen Sonuçlar

```bash
  Container mode: app

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\TasksControllerTest
  ✓ store creates a task                                                 0.38s
  ✓ update changes task status                                           0.01s
  ✓ destroy deletes task                                                 0.01s

  Tests:    4 passed (8 assertions)
  Duration: 0.43s
```

Kurulum yaptıktan sonra 

`php artisan migrate` ve `php artisan db:seed` komutlarını çalıştırarak veritabanı tablolarını ve örnek verileri oluşturabilirsiniz.
