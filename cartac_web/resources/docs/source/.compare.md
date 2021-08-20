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
    -d '{"email":"reprehenderit","pass":"aut","cedula":"aliquam","name":"est","apellidos":"nam","phone":"itaque","con_hora_trabajo":"sed","address":"sit","photo":"qui","wallet_type":"commodi","wallet_number":"eius","cedula_f":"rem","cedula_r":"provident","licencia_c":"praesentium","cert_banc":"dolorem","esPropietario":"dicta","push_token":"fuga"}'

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
    "email": "reprehenderit",
    "pass": "aut",
    "cedula": "aliquam",
    "name": "est",
    "apellidos": "nam",
    "phone": "itaque",
    "con_hora_trabajo": "sed",
    "address": "sit",
    "photo": "qui",
    "wallet_type": "commodi",
    "wallet_number": "eius",
    "cedula_f": "rem",
    "cedula_r": "provident",
    "licencia_c": "praesentium",
    "cert_banc": "dolorem",
    "esPropietario": "dicta",
    "push_token": "fuga"
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
        `push_token` | String |  optional  | Token de firebase.
    
<!-- END_e079d75507413011cb8fbacf2bb41ad6 -->

<!-- START_dd7d1777a6d3b6a7f46cb04077c733bf -->
## Login de conductor

> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/conductor/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"deleniti","pass":"quia","push_token":"suscipit"}'

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
    "email": "deleniti",
    "pass": "quia",
    "push_token": "suscipit"
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
        `push_token` | String |  required  | Token de firebase.
    
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
    -d '{"email":"facilis","cedula":"aut","name":"autem","apellidos":"aut","fk_user_conductor":"enim","cedula_f":"assumenda","cedula_r":"temporibus","carta_auto":"dolores"}'

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
    "email": "facilis",
    "cedula": "aut",
    "name": "autem",
    "apellidos": "aut",
    "fk_user_conductor": "enim",
    "cedula_f": "assumenda",
    "cedula_r": "temporibus",
    "carta_auto": "dolores"
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
    -d '{"dimension":"sit","typeFk":"amet","placa":"dolor","image":"facere","fkCarColor":"quidem","fkCarBrand":"commodi","veh_rendimiento":"sed","id_owner":"totam","fkUserConductor":"explicabo","subCategoryFk":"sint","tarjeta_prop":"repudiandae","soat":"quas","tecno":"autem"}'

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
    "dimension": "sit",
    "typeFk": "amet",
    "placa": "dolor",
    "image": "facere",
    "fkCarColor": "quidem",
    "fkCarBrand": "commodi",
    "veh_rendimiento": "sed",
    "id_owner": "totam",
    "fkUserConductor": "explicabo",
    "subCategoryFk": "sint",
    "tarjeta_prop": "repudiandae",
    "soat": "quas",
    "tecno": "autem"
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


> Example response (500):

```json
{
    "success": false,
    "message": "Error de consulta BDD ",
    "0": "SQLSTATE[HY000] [2002] No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión.\r\n (SQL: select `col_id` as `id`, `col_name` as `name` from `color_veh`)"
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


> Example response (500):

```json
{
    "success": false,
    "message": "Error de consulta BDD ",
    "0": "SQLSTATE[HY000] [2002] No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión.\r\n (SQL: select `mar_id` as `id`, `mar_name` as `name` from `marca_veh`)"
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


> Example response (500):

```json
{
    "success": false,
    "message": "Error de consulta BDD ",
    "0": "SQLSTATE[HY000] [2002] No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión.\r\n (SQL: select * from `dimension_veh`)"
}
```

### HTTP Request
`GET api/dimension_vehiculo`


<!-- END_cc0b523a837eac3b3d5d77d03624abaf -->

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


> Example response (500):

```json
{
    "success": false,
    "message": "Error de consulta BDD ",
    "0": "SQLSTATE[HY000] [2002] No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión.\r\n (SQL: select `cat_id` as `id`, `cat_name` as `name`, `cat_icono` as `imagen` from `categoria` where `cat_fk_cat` is null)"
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


> Example response (500):

```json
{
    "success": false,
    "message": "Error de consulta BDD ",
    "0": "SQLSTATE[HY000] [2002] No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión.\r\n (SQL: select `cat_id` as `id`, `cat_name` as `name`, `cat_icono` as `imagen` from `categoria` where `cat_fk_cat` is null)"
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
    -d '{"parametro_respuesta":"qui","id_documentos":"fugiat","documentos":"eos"}'

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
    "parametro_respuesta": "qui",
    "id_documentos": "fugiat",
    "documentos": "eos"
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
    -d '{"cli_nombres":"qui","cli_apellidos":"nesciunt","cli_email":"excepturi","cli_pass":"qui","cli_foto":"eum","cli_red":"asperiores","cli_id_red":"tempore","push_token":"quas"}'

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
    "cli_nombres": "qui",
    "cli_apellidos": "nesciunt",
    "cli_email": "excepturi",
    "cli_pass": "qui",
    "cli_foto": "eum",
    "cli_red": "asperiores",
    "cli_id_red": "tempore",
    "push_token": "quas"
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
        `push_token` | String |  optional  | Token de firebase.
    
<!-- END_a8214f7698759b766de456fa95811130 -->

<!-- START_ea71a2e0bf12e55039c3666b39ec8975 -->
## Login de cliente

> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/cliente/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"magnam","pass":"natus","push_token":"voluptates"}'

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
    "email": "magnam",
    "pass": "natus",
    "push_token": "voluptates"
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
        `push_token` | String |  optional  | Token de firebase.
    
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
    -d '{"veh_id":"iure"}'

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
    "veh_id": "iure"
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
    -d '{"lat":"iusto","lng":"sit","veh_id":"at"}'

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
    "lat": "iusto",
    "lng": "sit",
    "veh_id": "at"
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
    -d '{"lat_ini":"et","lng_ini":"delectus","lat_fin":"dolorem","lng_fin":"eum","tipo_veh":"delectus"}'

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
    "lng_ini": "delectus",
    "lat_fin": "dolorem",
    "lng_fin": "eum",
    "tipo_veh": "delectus"
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
    -d '{"ser_id":"quisquam","veh_id":"magni"}'

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
    "ser_id": "quisquam",
    "veh_id": "magni"
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

#v 1.0.4


<!-- START_d1acd3b05a50c416ad35673301364f25 -->
## Modificar cliente

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/cliente/modificar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"cli_nombres":"est","cli_apellidos":"ipsam","cli_email":"quae","cli_pass":"qui","cli_foto":"et"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/cliente/modificar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cli_nombres": "est",
    "cli_apellidos": "ipsam",
    "cli_email": "quae",
    "cli_pass": "qui",
    "cli_foto": "et"
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
`POST api/cliente/modificar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `cli_nombres` | String |  required  | Nombres del cliente.
        `cli_apellidos` | String |  required  | Apellidos del cliente.
        `cli_email` | String |  required  | Email del cliente.
        `cli_pass` | String |  optional  | Password del cliente.
        `cli_foto` | String/File |  optional  | Puede ser un archivo o una imagen en base 64 de la foto del cliente.
    
<!-- END_d1acd3b05a50c416ad35673301364f25 -->

<!-- START_247638557a5e685b01373801e0ba8f51 -->
## Consultar direcciones
Permite consultar direcciones de los clientes

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "https://desarrollocartac.web-html.com/api/cliente/direccion" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/cliente/direccion"
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
`GET api/cliente/direccion`


<!-- END_247638557a5e685b01373801e0ba8f51 -->

<!-- START_ea9a5464a1a5c68831f64f4f197684f1 -->
## Agregar dirección
Permite agregar una dirección a un cliente

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/cliente/direccion/agregar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"direccion":"esse","lat":"est","lng":"et"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/cliente/direccion/agregar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "direccion": "esse",
    "lat": "est",
    "lng": "et"
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
`POST api/cliente/direccion/agregar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `direccion` | String |  required  | Dirección en texto.
        `lat` | Double |  required  | latitud de la dirección
        `lng` | Double |  required  | longitud de la dirección
    
<!-- END_ea9a5464a1a5c68831f64f4f197684f1 -->

<!-- START_5464e7109e3711c0df025e6e6845e694 -->
## Modificar dirección
Permite modificar una dirección a un cliente

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X PUT \
    "https://desarrollocartac.web-html.com/api/cliente/direccion/modificar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"direccion":"esse","lat":"dignissimos","lng":"placeat","dir_id":"minus"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/cliente/direccion/modificar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "direccion": "esse",
    "lat": "dignissimos",
    "lng": "placeat",
    "dir_id": "minus"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/cliente/direccion/modificar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `direccion` | String |  required  | Dirección en texto.
        `lat` | Double |  required  | latitud de la dirección
        `lng` | Double |  required  | longitud de la dirección
        `dir_id` | Integer |  required  | id de la dirección que se quiere modificar
    
<!-- END_5464e7109e3711c0df025e6e6845e694 -->

<!-- START_2bf8ea50f2672e1c26919f4603f3b23b -->
## Eliminar dirección
Permite eliminar una dirección a un cliente

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "https://desarrollocartac.web-html.com/api/cliente/direccion/eliminar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"dir_id":"ea"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/cliente/direccion/eliminar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "dir_id": "ea"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/cliente/direccion/eliminar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `dir_id` | Integer |  required  | id de la dirección que se quiere eliminar
    
<!-- END_2bf8ea50f2672e1c26919f4603f3b23b -->

<!-- START_52d4485eb677aaabeab3f425c5e3c5c3 -->
## Cambiar estado servicio
Permite cambiar el estado del servicio por parte del conductor, Estados: 10 - CONDUCTOR ESPERANDO, 11 - TERMINADO, 7 - EN VIAJE

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/servicio/cambiar_estado" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ser_id":"possimus","est_id":"odio"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/cambiar_estado"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ser_id": "possimus",
    "est_id": "odio"
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
`POST api/servicio/cambiar_estado`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ser_id` | Integer |  required  | Id del servicio.
        `est_id` | Integer |  required  | Id del estado.
    
<!-- END_52d4485eb677aaabeab3f425c5e3c5c3 -->

<!-- START_b9fe0598a1ca06a44ff00057598cfae9 -->
## Ver datos del servicio
Permite ver la ubicación del vehiculo que presta el servicio por parte del cliente

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/servicio/ver_datos" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ser_id":"quis"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/ver_datos"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ser_id": "quis"
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
`POST api/servicio/ver_datos`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ser_id` | Integer |  required  | Id del servicio.
    
<!-- END_b9fe0598a1ca06a44ff00057598cfae9 -->

<!-- START_63c475949e428562c486db3cbbb315e7 -->
## Cancelar servicio
Permite cancelar el servicio por parte del cliente

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/servicio/cancelar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ser_id":"illum","motivo":"ea"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/cancelar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ser_id": "illum",
    "motivo": "ea"
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
`POST api/servicio/cancelar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ser_id` | Integer |  required  | Id del servicio.
        `motivo` | String |  required  | Motivo por el  que cancela
    
<!-- END_63c475949e428562c486db3cbbb315e7 -->

<!-- START_b1f192c084fadec872b34fe08a50b6f9 -->
## Calificar servicio
Permite calificar el servicio por parte del cliente

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/servicio/calificar" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ser_id":"libero","calificacion":"qui","opinion":"sit"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/calificar"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ser_id": "libero",
    "calificacion": "qui",
    "opinion": "sit"
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
`POST api/servicio/calificar`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ser_id` | Integer |  required  | Id del servicio.
        `calificacion` | Integer |  required  | Número del 0 al 5 que indica la calificación del servicio.
        `opinion` | String |  optional  | Opinion acerca del servicio.
    
<!-- END_b1f192c084fadec872b34fe08a50b6f9 -->

#v 1.0.5


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
    -d '{"lat_ini":"voluptas","lng_ini":"dignissimos","lat_fin":"harum","lng_fin":"expedita","direccion_inicio":"accusantium","direccion_fin":"voluptas","tipo_veh":"sunt","dimension":"ut","categoria":"natus","aplica_seguro":"et","bono":"ea"}'

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
    "lat_ini": "voluptas",
    "lng_ini": "dignissimos",
    "lat_fin": "harum",
    "lng_fin": "expedita",
    "direccion_inicio": "accusantium",
    "direccion_fin": "voluptas",
    "tipo_veh": "sunt",
    "dimension": "ut",
    "categoria": "natus",
    "aplica_seguro": "et",
    "bono": "ea"
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
        `aplica_seguro` | Integer |  required  | 0 o 1 si aplica el seguro.
        `bono` | String |  optional  | optional Bono de descuento.
    
<!-- END_0c831c48e92f095e552fdb86f2b4cdd1 -->

<!-- START_8957fed5ca13c0ea70f71591b8296a76 -->
## Historial de servicios
Permite ver los servicios que han sido calificados por parte del cliente

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "https://desarrollocartac.web-html.com/api/servicio/historial" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/historial"
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
`POST api/servicio/historial`


<!-- END_8957fed5ca13c0ea70f71591b8296a76 -->

<!-- START_6b642b4c24dc59176b1ee7dd632ab146 -->
## Tipos vehiculos

> Example request:

```bash
curl -X GET \
    -G "https://desarrollocartac.web-html.com/api/tipo_vehiculo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"categoria":"ab"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/tipo_vehiculo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "categoria": "ab"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "success": false,
    "message": "Error de consulta BDD ",
    "0": "SQLSTATE[HY000] [2002] No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión.\r\n (SQL: select `tip_id` as `id`, `tip_name` as `name`, `tip_foto` as `foto`, `tip_foto` as `foto` from `tipo_veh` inner join `dimension_tipo_veh` on `fk_tip` = `tip_id` inner join `vehiculo` on `veh_fk_dim_tip` = `id` inner join `vehiculo_categoria` on `fk_veh_id` = `veh_id` where `fk_cat_id` = ab)"
}
```

### HTTP Request
`GET api/tipo_vehiculo`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `categoria` | Integer |  optional  | Id de la categoria.
    
<!-- END_6b642b4c24dc59176b1ee7dd632ab146 -->

#v 1.0.6


<!-- START_6b4363ff719134bcbfaa0795d6ff4006 -->
## buscar_conductor
Busca conductores y envia push segun la ubicacion de estos en un radio de 2,5,10 km a la redonda, si no aceptan envia push a cliente informando, se debe usar cada 5 mins para dar tiempo a los conductores de responder

> Example request:

```bash
curl -X GET \
    -G "https://desarrollocartac.web-html.com/api/servicio/buscar_conductor" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/servicio/buscar_conductor"
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


> Example response (500):

```json
{
    "success": false,
    "message": "Error de consulta BDD ",
    "0": "SQLSTATE[HY000] [2002] No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión.\r\n (SQL: select ST_X(ser_ubicacion_ini) as lat_ini, ST_Y(ser_ubicacion_ini) as lng_ini,\n        ser_busqueda_distancia_km, ser_fk_est, ser_id from `servicio` where `ser_fk_est` = 8)"
}
```

### HTTP Request
`GET api/servicio/buscar_conductor`


<!-- END_6b4363ff719134bcbfaa0795d6ff4006 -->

<!-- START_eac05d2cbb7aa6aa4c194712126dea3d -->
## testPush
Probar Push de cliente y conductor

> Example request:

```bash
curl -X GET \
    -G "https://desarrollocartac.web-html.com/api/testPush" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"tipo":"et","push_token":"recusandae"}'

```

```javascript
const url = new URL(
    "https://desarrollocartac.web-html.com/api/testPush"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "tipo": "et",
    "push_token": "recusandae"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "res": {
        "cookies": {},
        "transferStats": {}
    },
    "res2": {
        "cookies": {},
        "transferStats": {}
    }
}
```

### HTTP Request
`GET api/testPush`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `tipo` | Integer |  required  | 1 para conductor, 2 para cliente.
        `push_token` | String |  required  | Token de firebase.
    
<!-- END_eac05d2cbb7aa6aa4c194712126dea3d -->


