---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](127.0.0.1:8000/docs/collection.json)

<!-- END_INFO -->

#v 1.0


<!-- START_e079d75507413011cb8fbacf2bb41ad6 -->
## Crear conductores

> Example request:

```bash
curl -X POST \
    "127.0.0.1:8000/api/conductor/agregar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"est","pass":"voluptatibus","cedula":"veritatis","name":"et","apellidos":"autem","phone":"vel","con_hora_trabajo":"harum","address":"non","photo":"ducimus","wallet_type":"necessitatibus","wallet_number":"dolorem","cedula_f":"esse","cedula_r":"quis","licencia_c":"modi","cert_banc":"quia","esPropietario":"velit"}'

```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/conductor/agregar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "est",
    "pass": "voluptatibus",
    "cedula": "veritatis",
    "name": "et",
    "apellidos": "autem",
    "phone": "vel",
    "con_hora_trabajo": "harum",
    "address": "non",
    "photo": "ducimus",
    "wallet_type": "necessitatibus",
    "wallet_number": "dolorem",
    "cedula_f": "esse",
    "cedula_r": "quis",
    "licencia_c": "modi",
    "cert_banc": "quia",
    "esPropietario": "velit"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/conductor/agregar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | String |  required  | email del conductor.
        `pass` | String |  required  | contraseña para el conductor.
        `cedula` | Integer |  required  | cedula del conductor.
        `name` | String |  required  | nombres del conductor.
        `apellidos` | String |  required  | apellidos del conductor.
        `phone` | Integer |  optional  | Teléfono del conductor.
        `con_hora_trabajo` | Integer |  optional  | Valor hora de trabajo del conductor.
        `address` | String |  required  | Dirección del conductor.
        `photo` | String |  required  | Foto del conductor en base 64.
        `wallet_type` | Integer |  optional  | Tipo de billetera virtual 0-Nequi, 1-Daviplata.
        `wallet_number` | Integer |  optional  | Numero celular de billetera virtual.
        `cedula_f` | String |  required  | Foto de la cedula frontal del conductor en base 64.
        `cedula_r` | String |  required  | Foto de la cedula respaldo del conductor en base 64.
        `licencia_c` | String |  required  | Foto de la licencia de conducción del conductor en base 64.
        `cert_banc` | String |  optional  | Foto de la certificación bancaria del conductor en base 64.
        `esPropietario` | Integer |  optional  | Si se envia en 1 el conductor es propietario.
    
<!-- END_e079d75507413011cb8fbacf2bb41ad6 -->

<!-- START_dd7d1777a6d3b6a7f46cb04077c733bf -->
## Login de conductor

> Example request:

```bash
curl -X POST \
    "127.0.0.1:8000/api/conductor/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"qui","pass":"aut"}'

```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/conductor/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "qui",
    "pass": "aut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/conductor/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | String |  required  | Email del conductor.
        `pass` | String |  required  | Contraseña del conductor.
    
<!-- END_dd7d1777a6d3b6a7f46cb04077c733bf -->

<!-- START_e88f4b4f558e6a596da8bb36b6f618a7 -->
## Datos conductor
Trae los datos de un conductor segun el token del login

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "127.0.0.1:8000/api/conductor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/conductor"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "success": false,
    "message": "Error de autenticación"
}
```

### HTTP Request
`GET api/conductor`


<!-- END_e88f4b4f558e6a596da8bb36b6f618a7 -->

<!-- START_3b2141bc333fbf11130d3df647ffa4e7 -->
## Agregar propietarios

> Example request:

```bash
curl -X POST \
    "127.0.0.1:8000/api/propietario/agregar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"aut","cedula":"sed","name":"sed","apellidos":"a","fk_user_conductor":"expedita","cedula_f":"nostrum","cedula_r":"eligendi","carta_auto":"veniam"}'

```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/propietario/agregar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "aut",
    "cedula": "sed",
    "name": "sed",
    "apellidos": "a",
    "fk_user_conductor": "expedita",
    "cedula_f": "nostrum",
    "cedula_r": "eligendi",
    "carta_auto": "veniam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/propietario/agregar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | String |  required  | Email del propietario.
        `cedula` | String |  required  | Cedula del propietario.
        `name` | String |  required  | Nombres del propietario.
        `apellidos` | String |  required  | Apellidos del propietario.
        `fk_user_conductor` | Integer |  required  | Id del conductor del servicio /conductor/agregar.
        `cedula_f` | String |  required  | Foto de la cedula frontal del propietario en base 64.
        `cedula_r` | String |  required  | Foto de la cedula respaldo del propietario en base 64.
        `carta_auto` | String |  required  | Foto de la carta de autorización del propietario en base 64.
    
<!-- END_3b2141bc333fbf11130d3df647ffa4e7 -->

<!-- START_416b832aeb3f1b44d1f8edacb9d74ace -->
## Agregar vehiculos

> Example request:

```bash
curl -X POST \
    "127.0.0.1:8000/api/vehiculo/agregar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"dimension":"consequuntur","typeFk":"sit","placa":"dolorem","image":"voluptatum","fkCarColor":"dicta","fkCarBrand":"labore","veh_rendimiento":"non","id_owner":"est","fkUserConductor":"maiores","subCategoryFk":"ea","tarjeta_prop":"laborum","soat":"voluptatem","tecno":"harum"}'

```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/vehiculo/agregar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "dimension": "consequuntur",
    "typeFk": "sit",
    "placa": "dolorem",
    "image": "voluptatum",
    "fkCarColor": "dicta",
    "fkCarBrand": "labore",
    "veh_rendimiento": "non",
    "id_owner": "est",
    "fkUserConductor": "maiores",
    "subCategoryFk": "ea",
    "tarjeta_prop": "laborum",
    "soat": "voluptatem",
    "tecno": "harum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/vehiculo/agregar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `dimension` | Integer |  required  | Id de la dimensión del vehiculo se obtiene en: api/dimension_vehiculo.
        `typeFk` | Integer |  required  | Id del tipo del vehiculo se obtiene en: api/tipo_vehiculo.
        `placa` | String |  required  | Placa del vehiculo (Formato recomendado AAA-000).
        `image` | String |  required  | Foto del vehiculo en base 64.
        `fkCarColor` | Integer |  required  | Id del color del vehiculo se obtiene en: api/color_vehiculo.
        `fkCarBrand` | Integer |  required  | Id de la marca del vehiculo se obtiene en: api/marca_vehiculo.
        `veh_rendimiento` | String |  optional  | Rendimiento del vehiculo por galón.
        `id_owner` | Integer |  optional  | Id del propietario en caso de que no sea el conductor.
        `fkUserConductor` | Integer |  required  | Id del conductor.
        `subCategoryFk` | String |  required  | Categorias y sub-categorias separadas por comas.
        `tarjeta_prop` | String |  required  | Foto de la tarjeta de propiedad del vehiculo en base 64.
        `soat` | String |  required  | Foto del Soat del vehiculo en base 64.
        `tecno` | String |  required  | Foto de la tecnomecanica del vehiculo en base 64.
    
<!-- END_416b832aeb3f1b44d1f8edacb9d74ace -->

<!-- START_8a86b072dff07bcce8c11d27afbef616 -->
## Colores vehiculos

> Example request:

```bash
curl -X GET \
    -G "127.0.0.1:8000/api/color_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/color_vehiculo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Negro"
        },
        {
            "id": 2,
            "name": "Rojo"
        },
        {
            "id": 3,
            "name": "Verde"
        },
        {
            "id": 4,
            "name": "Morado"
        },
        {
            "id": 5,
            "name": "Gris"
        },
        {
            "id": 6,
            "name": "Gris plateado"
        },
        {
            "id": 7,
            "name": "Plateado"
        },
        {
            "id": 8,
            "name": "Azul"
        },
        {
            "id": 9,
            "name": "Azul plateado"
        },
        {
            "id": 10,
            "name": "Cafe"
        },
        {
            "id": 11,
            "name": "Marron"
        },
        {
            "id": 12,
            "name": "Lila"
        },
        {
            "id": 13,
            "name": "amarillo"
        },
        {
            "id": 14,
            "name": "Blanco"
        },
        {
            "id": 15,
            "name": "Blanco abano"
        },
        {
            "id": 16,
            "name": "Blanco Perla"
        },
        {
            "id": 17,
            "name": "Dorado"
        },
        {
            "id": 18,
            "name": "Naranja"
        }
    ]
}
```

### HTTP Request
`GET api/color_vehiculo`


<!-- END_8a86b072dff07bcce8c11d27afbef616 -->

<!-- START_4dd2b1c538764c46006dcf3659febe60 -->
## Marcas vehiculos

> Example request:

```bash
curl -X GET \
    -G "127.0.0.1:8000/api/marca_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/marca_vehiculo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Renault"
        },
        {
            "id": 2,
            "name": "Chevrolet"
        },
        {
            "id": 3,
            "name": "Mazda"
        },
        {
            "id": 4,
            "name": "Nissan"
        },
        {
            "id": 5,
            "name": "Kia"
        },
        {
            "id": 6,
            "name": "Toyota"
        },
        {
            "id": 7,
            "name": "Volkswagen"
        },
        {
            "id": 8,
            "name": "Suzuki"
        },
        {
            "id": 9,
            "name": "Toyota"
        },
        {
            "id": 10,
            "name": "Mercedes-Benz"
        },
        {
            "id": 11,
            "name": "Fiat"
        },
        {
            "id": 12,
            "name": "Dodge"
        },
        {
            "id": 13,
            "name": "Honda"
        },
        {
            "id": 14,
            "name": "Jeep"
        },
        {
            "id": 15,
            "name": "Mini"
        },
        {
            "id": 16,
            "name": "Peugeot"
        },
        {
            "id": 17,
            "name": "Skoda"
        }
    ]
}
```

### HTTP Request
`GET api/marca_vehiculo`


<!-- END_4dd2b1c538764c46006dcf3659febe60 -->

<!-- START_cc0b523a837eac3b3d5d77d03624abaf -->
## Dimensiones vehiculos

> Example request:

```bash
curl -X GET \
    -G "127.0.0.1:8000/api/dimension_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/dimension_vehiculo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "dim_id": 1,
            "dim_name": "Grande"
        },
        {
            "dim_id": 2,
            "dim_name": "Mediano"
        },
        {
            "dim_id": 3,
            "dim_name": "Pequeño"
        }
    ]
}
```

### HTTP Request
`GET api/dimension_vehiculo`


<!-- END_cc0b523a837eac3b3d5d77d03624abaf -->

<!-- START_6b642b4c24dc59176b1ee7dd632ab146 -->
## Tipos vehiculos

> Example request:

```bash
curl -X GET \
    -G "127.0.0.1:8000/api/tipo_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/tipo_vehiculo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "MOTOCARRO"
        },
        {
            "id": 2,
            "name": "CAMIONETA PLATON"
        },
        {
            "id": 3,
            "name": "VANS DE CARGA"
        },
        {
            "id": 4,
            "name": "REMOLQUE ABIERTO"
        },
        {
            "id": 5,
            "name": "FURGON"
        },
        {
            "id": 6,
            "name": "FURGON GRANDE TURBO"
        },
        {
            "id": 7,
            "name": "TRACTOCAMION 4 EJES"
        },
        {
            "id": 8,
            "name": "TRACTOCAMION 6 EJES"
        },
        {
            "id": 9,
            "name": "VOLQUETA"
        },
        {
            "id": 10,
            "name": "CAMION TRANS CONTAINER (PLANCHON CON UÑAS)"
        },
        {
            "id": 11,
            "name": "CAMION CISTERNA"
        },
        {
            "id": 12,
            "name": "CAMION FRIGORIFICO"
        },
        {
            "id": 13,
            "name": "CAMION PLANCHA"
        },
        {
            "id": 14,
            "name": "CAMION NINERA"
        },
        {
            "id": 15,
            "name": "CAMION GRUA"
        },
        {
            "id": 16,
            "name": "CAMION CAMA BAJA"
        },
        {
            "id": 17,
            "name": "CAMION CON ESTACAS"
        },
        {
            "id": 18,
            "name": "CAMION CON CARPA"
        },
        {
            "id": 19,
            "name": "GRUA PARA VEHICULO"
        },
        {
            "id": 20,
            "name": "GRUA PARA MOTO"
        }
    ]
}
```

### HTTP Request
`GET api/tipo_vehiculo`


<!-- END_6b642b4c24dc59176b1ee7dd632ab146 -->

<!-- START_ae738c5eae45bc48c5b1e77daa3f8c5c -->
## Categorias vehiculos

> Example request:

```bash
curl -X GET \
    -G "127.0.0.1:8000/api/categoria" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/categoria"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Empresas y Negocios",
            "imagen": null
        },
        {
            "id": 2,
            "name": "Hogar",
            "imagen": null
        },
        {
            "id": 3,
            "name": "Alimentos",
            "imagen": null
        },
        {
            "id": 4,
            "name": "Carga especial",
            "imagen": null
        }
    ],
    "pathImage": ""
}
```

### HTTP Request
`GET api/categoria`


<!-- END_ae738c5eae45bc48c5b1e77daa3f8c5c -->

<!-- START_b61128b96a2ca049eddc7ac6dcbcddbc -->
## Sub-Categorias vehiculos

> Example request:

```bash
curl -X GET \
    -G "127.0.0.1:8000/api/sub_categoria" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "127.0.0.1:8000/api/sub_categoria"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Empresas y Negocios",
            "imagen": null
        },
        {
            "id": 2,
            "name": "Hogar",
            "imagen": null
        },
        {
            "id": 3,
            "name": "Alimentos",
            "imagen": null
        },
        {
            "id": 4,
            "name": "Carga especial",
            "imagen": null
        }
    ],
    "pathImage": ""
}
```

### HTTP Request
`GET api/sub_categoria`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `categoryFk` |  required  | Id de la categoria superior

<!-- END_b61128b96a2ca049eddc7ac6dcbcddbc -->


