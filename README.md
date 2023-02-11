#### CI/CD status

![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/deepak0023/laravel_test/laravel.yml)    ![Laravel Version](https://img.shields.io/badge/laravel-9.51-orange)

# Laravel Test

This is a test project mainly for interview purpose :

- Firstly create db in the setup and get the credentials
- create an .env and update db configuration
- Generate key if not generated
- run migration
- Make changes in the corresponding db seeder and run specific seeder

## API Endpoints Supported

```sh
[GET] http://<domain>/api/v1/travel_history/<traveller_id>?from_date=<from-date>&to_date=<to-date>
```
```sh
[GET ]http://<domain>/api/v1/travel_count/<from-date>/<to-date>
```

## Examples

#### Input Request

```sh
[GET] http://localhost:8000/api/v1/travel_history/1?from_date=2022-12-01&to_date=2022-12-31
```
#### Output Response

```sh
{
   "status":"success",
   "data":[
      {
         "city_name":"Mumbai",
         "from_date":"2022-12-22",
         "to_date":"2022-12-23"
      },
      {
         "city_name":"Chennai",
         "from_date":"2022-12-25",
         "to_date":"2022-12-27"
      }
   ]
}
```

#### Input Request

```sh
[GET] http://localhost:8000/api/v1/travel_count/2022-12-01/2022-12-31
```

#### Output Response

```sh
{
   "status":"success",
   "data":[
      {
         "city_name":"Chennai",
         "traveller_count":1
      },
      {
         "city_name":"Mumbai",
         "traveller_count":1
      }
   ]
}
```
