<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Api general de la fabrica de software Tecnofactory",
 *     version="1.0",
 *     description="Listado de URL de la api, este se encuentra dividido por peticiones a cada una de las tablas de la base de datos."
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="apiUserAuth",
 *     type="apiKey",
 *     in="header",
 *     name="x-api-user"
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="apiKeyAuth",
 *     type="apiKey",
 *     in="header",
 *     name="x-api-key"
 * ),
 * @OA\Server(url="http://127.0.0.1:8000")
 */
class SwaggerDocumentation {}
