## Application powered by Laravel

[![Build Status](https://travis-ci.org/laracloset/app.svg?branch=master)](https://travis-ci.org/laracloset/app)
[![codecov](https://codecov.io/gh/laracloset/app/branch/master/graph/badge.svg)](https://codecov.io/gh/laracloset/app)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/laracloset/app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/laracloset/app/?branch=master)

## Local Setup

### Requirements

- Docker

### Install

```shell
git clone https://github.com/laracloset/app.git
```

### Usage

```shell
cp .env.example .env && docker-compose up -d
```

### Containers

#### Application

Admin

http://localhost:8000/admin/home

```
id: admin@example.com
password: secret
```

#### Mysql

```shell
mysql -u root -p secret -P 33060 -D homestead
```

#### MinIO

http://localhost:9000/minio/

