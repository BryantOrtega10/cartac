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
[Get Postman Collection](http://desarrollocartac.web-html.com/docs/collection.json)

<!-- END_INFO -->

#v 1.0


<!-- START_e079d75507413011cb8fbacf2bb41ad6 -->
## Crear conductores

> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/conductor/agregar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"et","pass":"placeat","cedula":"debitis","name":"facilis","apellidos":"sed","phone":"hic","con_hora_trabajo":"enim","address":"vel","photo":"assumenda","wallet_type":"sapiente","wallet_number":"veniam","cedula_f":"soluta","cedula_r":"dolore","licencia_c":"et","cert_banc":"voluptates","esPropietario":"quas"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/conductor/agregar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "et",
    "pass": "placeat",
    "cedula": "debitis",
    "name": "facilis",
    "apellidos": "sed",
    "phone": "hic",
    "con_hora_trabajo": "enim",
    "address": "vel",
    "photo": "assumenda",
    "wallet_type": "sapiente",
    "wallet_number": "veniam",
    "cedula_f": "soluta",
    "cedula_r": "dolore",
    "licencia_c": "et",
    "cert_banc": "voluptates",
    "esPropietario": "quas"
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
    "https://desarrollocartac.web-html.com/api/conductor/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"beatae","pass":"assumenda"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/conductor/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "beatae",
    "pass": "assumenda"
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
    -G "https://desarrollocartac.web-html.com/api/conductor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/conductor"
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
    "https://desarrollocartac.web-html.com/api/propietario/agregar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"enim","cedula":"tenetur","name":"voluptatem","apellidos":"aut","fk_user_conductor":"iure","cedula_f":"minima","cedula_r":"nam","carta_auto":"qui"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/propietario/agregar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "enim",
    "cedula": "tenetur",
    "name": "voluptatem",
    "apellidos": "aut",
    "fk_user_conductor": "iure",
    "cedula_f": "minima",
    "cedula_r": "nam",
    "carta_auto": "qui"
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
    "https://desarrollocartac.web-html.com/api/vehiculo/agregar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"dimension":"voluptatem","typeFk":"provident","placa":"et","image":"praesentium","fkCarColor":"praesentium","fkCarBrand":"dolor","veh_rendimiento":"consequatur","id_owner":"facilis","fkUserConductor":"officiis","subCategoryFk":"recusandae","tarjeta_prop":"doloremque","soat":"vel","tecno":"sapiente"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/vehiculo/agregar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "dimension": "voluptatem",
    "typeFk": "provident",
    "placa": "et",
    "image": "praesentium",
    "fkCarColor": "praesentium",
    "fkCarBrand": "dolor",
    "veh_rendimiento": "consequatur",
    "id_owner": "facilis",
    "fkUserConductor": "officiis",
    "subCategoryFk": "recusandae",
    "tarjeta_prop": "doloremque",
    "soat": "vel",
    "tecno": "sapiente"
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
    -G "https://desarrollocartac.web-html.com/api/color_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/color_vehiculo"
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
    -G "https://desarrollocartac.web-html.com/api/marca_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/marca_vehiculo"
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
    -G "https://desarrollocartac.web-html.com/api/dimension_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/dimension_vehiculo"
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
    -G "https://desarrollocartac.web-html.com/api/tipo_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/tipo_vehiculo"
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
    -G "https://desarrollocartac.web-html.com/api/categoria" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/categoria"
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
    -G "https://desarrollocartac.web-html.com/api/sub_categoria" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/sub_categoria"
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

#v 1.0.1


<!-- START_48c47782134563b6d69b920839e0245f -->
## Resubir datos conductor

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
La autorizacion es una variable header -> Authorization : Bearer token

> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/conductor/resubir" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"parametro_respuesta":"beatae","id_documentos":"et","documentos":"ut"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/conductor/resubir"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "parametro_respuesta": "beatae",
    "id_documentos": "et",
    "documentos": "ut"
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
`POST api/conductor/resubir`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `parametro_respuesta` | String |  optional  | Dato errado.
        `id_documentos` | [Array] |  optional  | Id del documento en orden.
        `documentos` | [Array] |  optional  | Documento en base 64 que coincida con el orden del campo anterior.
    
<!-- END_48c47782134563b6d69b920839e0245f -->

<!-- START_a8214f7698759b766de456fa95811130 -->
## Registrar cliente

> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/cliente/agregar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"cli_nombres":"error","cli_apellidos":"minima","cli_email":"non","cli_pass":"nam","cli_foto":"assumenda","cli_red":"modi","cli_id_red":"fuga"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/cliente/agregar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cli_nombres": "error",
    "cli_apellidos": "minima",
    "cli_email": "non",
    "cli_pass": "nam",
    "cli_foto": "assumenda",
    "cli_red": "modi",
    "cli_id_red": "fuga"
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
`POST api/cliente/agregar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `cli_nombres` | String |  required  | Nombres del cliente.
        `cli_apellidos` | String |  required  | Apellidos del cliente.
        `cli_email` | String |  required  | Email del cliente.
        `cli_pass` | String |  optional  | Password del cliente.
        `cli_foto` | String/File |  required  | Puede ser un archivo o una imagen en base 64 de la foto del cliente.
        `cli_red` | String |  required  | FACEBOOK, GOOGLE, APPLE, etc.
        `cli_id_red` | String |  required  | id de la red social.
    
<!-- END_a8214f7698759b766de456fa95811130 -->

<!-- START_ea71a2e0bf12e55039c3666b39ec8975 -->
## Login de cliente

> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/cliente/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"facere","pass":"doloribus"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/cliente/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "facere",
    "pass": "doloribus"
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
`POST api/cliente/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | String |  optional  | Email del cliente.
        `pass` | String |  optional  | Contraseña del cliente o id de la red social.
    
<!-- END_ea71a2e0bf12e55039c3666b39ec8975 -->

#v 1.0.3


<!-- START_d65755dbd8d30504ceb0a6c278f1dd32 -->
## Ver datos erroneos de conductor

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/conductor/datosErroneos" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/conductor/datosErroneos"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/conductor/datosErroneos`


<!-- END_d65755dbd8d30504ceb0a6c278f1dd32 -->

<!-- START_976433acc329b3695f4de245f9bc4173 -->
## Conectar al conductor
Permite que el conductor pueda aceptar viajes, se generó un cambio de la version 1.0.2

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/conductor/conectar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"veh_id":"quas"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/conductor/conectar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "veh_id": "quas"
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
`POST api/conductor/conectar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `veh_id` | Integer |  required  | Id del vehiculo con el que se conecta el conductor.
    
<!-- END_976433acc329b3695f4de245f9bc4173 -->

<!-- START_02bb5fb0151a291ffa1d627a77c93961 -->
## Actualizar ubicacion del conductor
Permite actualizar la ubicacion del conductor con cierto vehiculo

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/conductor/actualizarUbicacion" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"lat":"sit","lng":"quia","veh_id":"consequuntur"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/conductor/actualizarUbicacion"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "lat": "sit",
    "lng": "quia",
    "veh_id": "consequuntur"
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
`POST api/conductor/actualizarUbicacion`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `lat` | Double |  required  | latitud del conductor.
        `lng` | Double |  required  | longitud del conductor.
        `veh_id` | Integer |  required  | Id vehiculo.
    
<!-- END_02bb5fb0151a291ffa1d627a77c93961 -->

<!-- START_4149f3ef54e6ede4d09a98391e0a96db -->
## Cotizar servicio
Permite conocer el valor del servicio antes de generarlo

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/servicio/cotizar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"lat_ini":"et","lng_ini":"corrupti","lat_fin":"corporis","lng_fin":"a","tipo_veh":"nisi"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/cotizar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "lat_ini": "et",
    "lng_ini": "corrupti",
    "lat_fin": "corporis",
    "lng_fin": "a",
    "tipo_veh": "nisi"
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
`POST api/servicio/cotizar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `lat_ini` | Double |  required  | latitud de la ubicacion inicial.
        `lng_ini` | Double |  required  | longitud de la ubicacion inicial.
        `lat_fin` | Double |  required  | latitud de la ubicacion final.
        `lng_fin` | Double |  required  | longitud de la ubicacion final.
        `tipo_veh` | Integer |  required  | Id del tipo de vehiculo.
    
<!-- END_4149f3ef54e6ede4d09a98391e0a96db -->

<!-- START_0c831c48e92f095e552fdb86f2b4cdd1 -->
## Crear servicio
Permite crear el servicio

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/servicio/crear" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"lat_ini":"temporibus","lng_ini":"suscipit","lat_fin":"omnis","lng_fin":"voluptas","direccion_inicio":"nostrum","direccion_fin":"sit","tipo_veh":"quos","dimension":"quo","categoria":"quo"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/crear"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "lat_ini": "temporibus",
    "lng_ini": "suscipit",
    "lat_fin": "omnis",
    "lng_fin": "voluptas",
    "direccion_inicio": "nostrum",
    "direccion_fin": "sit",
    "tipo_veh": "quos",
    "dimension": "quo",
    "categoria": "quo"
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
`POST api/servicio/crear`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `lat_ini` | Double |  required  | latitud de la ubicacion inicial.
        `lng_ini` | Double |  required  | longitud de la ubicacion inicial.
        `lat_fin` | Double |  required  | latitud de la ubicacion final.
        `lng_fin` | Double |  required  | longitud de la ubicacion final.
        `direccion_inicio` | String |  required  | Dirección inicial que el cliente escribió.
        `direccion_fin` | String |  required  | Dirección final que el cliente escribió.
        `tipo_veh` | Integer |  required  | Id del tipo de vehiculo.
        `dimension` | Integer |  required  | Id dimension del vehiculo.
        `categoria` | Integer |  required  | Id de la categoria del vehiculo.
    
<!-- END_0c831c48e92f095e552fdb86f2b4cdd1 -->

<!-- START_af13537ec25e8857875b259cbd0455e6 -->
## Aceptar servicio
Permite Aceptar el servicio por parte del conductor, el id del servicio llega por una notificacion push

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/servicio/aceptar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ser_id":"et","veh_id":"et"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/aceptar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ser_id": "et",
    "veh_id": "et"
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
`POST api/servicio/aceptar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ser_id` | Integer |  required  | Id del servicio.
        `veh_id` | Integer |  required  | Id del vehiculo.
    
<!-- END_af13537ec25e8857875b259cbd0455e6 -->


