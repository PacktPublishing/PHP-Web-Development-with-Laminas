var spec = 
{
    "openapi": "3.0.0",
    "info": {
        "title": "Whatstore API",
        "version": "0.1"
    },
    "paths": {
        "/inventoryapi/discountapi/{key}": {
            "get": {
                "operationId": "5b879fefa48beab5061001a3ea2324a1",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "discount code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "get a discount"
                    }
                }
            },
            "put": {
                "operationId": "eac6c3db567ba403eef11d979fbb39f4",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "discount code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "operator",
                                    "factor"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "operator": {
                                        "type": "char"
                                    },
                                    "factor": {
                                        "type": "double"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "update a discount"
                    }
                }
            },
            "post": {
                "operationId": "352cf932bcaf9c0ad491a79fffe07bea",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "discount code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "operator",
                                    "factor"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "operator": {
                                        "type": "char"
                                    },
                                    "factor": {
                                        "type": "double"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert a discount"
                    }
                }
            },
            "delete": {
                "operationId": "877ec7922c3c919b9b62219a3e19b9ce",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "discount code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "remove a discount"
                    }
                }
            }
        },
        "/inventoryapi/discountapi": {
            "get": {
                "operationId": "3012f3d31da326b22f3421f45f3b2df0",
                "responses": {
                    "200": {
                        "description": "get list of discounts"
                    }
                }
            }
        },
        "/inventoryapi/employeeapi/{key}": {
            "get": {
                "operationId": "d9eb586c9794fe690e0e40c1b53a4cc1",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "employee ID",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "get an employee"
                    }
                }
            },
            "put": {
                "operationId": "df8e9bffcd78b0afbe88b23eae2905a5",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "employee ID",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "nickname",
                                    "password"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "nickname": {
                                        "type": "string"
                                    },
                                    "password": {
                                        "type": "string"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "update an employee"
                    }
                }
            },
            "post": {
                "operationId": "db3d93429b54a2775993b3b14fdb4b8c",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "employee ID",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "nickname",
                                    "password"
                                ],
                                "properties": {
                                    "ID": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "nickname": {
                                        "type": "string"
                                    },
                                    "password": {
                                        "type": "string"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert an employee"
                    }
                }
            },
            "delete": {
                "operationId": "638606c6567bde37d3e4b7df93439ca4",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "employee ID",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "remove an employee"
                    }
                }
            }
        },
        "/inventoryapi/employeeapi": {
            "get": {
                "operationId": "22f0031ad469e73764aa7f7acefd9808",
                "responses": {
                    "200": {
                        "description": "get list of employees"
                    }
                }
            }
        },
        "/inventoryapi/employeeroleapi/{key}": {
            "post": {
                "operationId": "1d995e74784942ddd0ecfcda2a9a31f4",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "employee role code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "code_role",
                                    "ID_employee"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "code_role": {
                                        "type": "integer"
                                    },
                                    "ID_employee": {
                                        "type": "integer"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert a employee role"
                    }
                }
            },
            "delete": {
                "operationId": "2ca8eb4b44d330c44886830aa18d4cd3",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "employee role code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "remove a employee role"
                    }
                }
            }
        },
        "/inventoryapi/inventoryapi/{key}": {
            "get": {
                "operationId": "ccf828b552e0ddd9347fd4091323c71c",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "get an inventory"
                    }
                }
            },
            "put": {
                "operationId": "43a6b5362f2a680ece74b5154fda8525",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "nickname",
                                    "password"
                                ],
                                "properties": {
                                    "code_product": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "operation": {
                                        "type": "string"
                                    },
                                    "amount": {
                                        "type": "integer"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "update an inventory"
                    }
                }
            }
        },
        "/inventoryapi/productapi/{key}": {
            "get": {
                "operationId": "c5fa61b89c9f23e9fc68cda3ce66a93a",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "get a product"
                    }
                }
            },
            "put": {
                "operationId": "14e0a94eae01d5580d2fe53c6cdf12fd",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "price",
                                    "code_discount"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "price": {
                                        "type": "float"
                                    },
                                    "code_discount": {
                                        "type": "integer"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "update a product"
                    }
                }
            },
            "post": {
                "operationId": "f49d93870a886459c50f6b1f53e3edd1",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "price",
                                    "code_discount"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "price": {
                                        "type": "float"
                                    },
                                    "code_discount": {
                                        "type": "integer"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert a product"
                    }
                }
            },
            "delete": {
                "operationId": "c705565d7d60524e8f8cfd41a4ea7b78",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "remove a product"
                    }
                }
            }
        },
        "/inventoryapi/productapi": {
            "get": {
                "operationId": "3ba289be29dc7e4062d29750429d036d",
                "responses": {
                    "200": {
                        "description": "get list of products"
                    }
                }
            }
        },
        "/inventoryapi/resourceapi/{key}": {
            "get": {
                "operationId": "f9ce3a1e641c5912c74f53e9706a93cb",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "resource code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "get a resource"
                    }
                }
            },
            "put": {
                "operationId": "35d2971640a790a2272e9dc4cbfbcbff",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "resource code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "method"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "method": {
                                        "type": "string"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "update a resource"
                    }
                }
            },
            "post": {
                "operationId": "f7d01853782e3d7750b3c5d84c895b99",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "resource code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "method"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "method": {
                                        "type": "string"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert a resource"
                    }
                }
            },
            "delete": {
                "operationId": "54f4973b96599041fcbe915068ecd78e",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "resource code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "remove a resource"
                    }
                }
            }
        },
        "/inventoryapi/resourceapi": {
            "get": {
                "operationId": "770074adb2a32d7c05d4a28f101829fd",
                "responses": {
                    "200": {
                        "description": "get list of resources"
                    }
                }
            }
        },
        "/inventoryapi/roleapi/{key}": {
            "get": {
                "operationId": "abebeb460ce9c0998ae93ea5c1f8db7d",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "role code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "get a role"
                    }
                }
            },
            "put": {
                "operationId": "7eda769a39b09927d8e5a4812c719cf2",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "role code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "nickname",
                                    "password"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "nickname": {
                                        "type": "string"
                                    },
                                    "password": {
                                        "type": "string"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "update a role"
                    }
                }
            },
            "post": {
                "operationId": "69b19b13eee9a41ea82696b7abbe6293",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "role code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "nickname",
                                    "password"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "nickname": {
                                        "type": "string"
                                    },
                                    "password": {
                                        "type": "string"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert a role"
                    }
                }
            },
            "delete": {
                "operationId": "83ddf6080dd2ba6788e958ff6c1e8723",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "role code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "remove a role"
                    }
                }
            }
        },
        "/inventoryapi/roleapi": {
            "get": {
                "operationId": "6bd6f5ba5169dbd6c9bdb4b43f8b297a",
                "responses": {
                    "200": {
                        "description": "get list of roles"
                    }
                }
            }
        },
        "/inventoryapi/roleresourceapi/{key}": {
            "post": {
                "operationId": "5bda5c9871b8a1eac69d4e360155817d",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "role resource code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "code_role",
                                    "code_resource"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "code_role": {
                                        "type": "integer"
                                    },
                                    "code_resource": {
                                        "type": "integer"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert a role resource"
                    }
                }
            },
            "delete": {
                "operationId": "e27a89e3cd61c7085799718ac8ba8e67",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "role resource code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "remove a role resource"
                    }
                }
            }
        },
        "/storeapi/customerapi/{key}": {
            "post": {
                "operationId": "7abd38927fcffa6e898d08ee7e10c87e",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "customer IDN",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "name",
                                    "password",
                                    "email"
                                ],
                                "properties": {
                                    "IDN": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "password": {
                                        "type": "string"
                                    },
                                    "email": {
                                        "type": "string"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert a customer"
                    }
                }
            }
        },
        "/storeapi/orderapi/{key}": {
            "post": {
                "operationId": "21e26631c3813779ca92697a7cab4426",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "order code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "insert a purchase order"
                    }
                }
            }
        },
        "/storeapi/productbasketapi/{key}": {
            "get": {
                "operationId": "8d134b4fb824c9c283edd9497d4148d9",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "get a product"
                    }
                }
            },
            "put": {
                "operationId": "d5d3cbc224640b469c39dd5bec69cb03",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "code",
                                    "name",
                                    "price",
                                    "amount"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "price": {
                                        "type": "float"
                                    },
                                    "amount": {
                                        "type": "integer"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "update a product"
                    }
                }
            },
            "post": {
                "operationId": "87f8c8024bac79df3bed7a6f24d545b9",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "requestBody": {
                    "content": {
                        "multipart/form-data": {
                            "schema": {
                                "required": [
                                    "code",
                                    "name",
                                    "price",
                                    "amount"
                                ],
                                "properties": {
                                    "code": {
                                        "type": "integer"
                                    },
                                    "name": {
                                        "type": "string"
                                    },
                                    "price": {
                                        "type": "float"
                                    },
                                    "amount": {
                                        "type": "integer"
                                    }
                                },
                                "type": "object"
                            }
                        }
                    }
                },
                "responses": {
                    "200": {
                        "description": "insert a product"
                    }
                }
            },
            "delete": {
                "operationId": "12cd666347192139d422eee20261443e",
                "parameters": [
                    {
                        "name": "key",
                        "in": "path",
                        "description": "product code",
                        "required": false
                    }
                ],
                "responses": {
                    "200": {
                        "description": "remove a product"
                    }
                }
            }
        }
    }
}