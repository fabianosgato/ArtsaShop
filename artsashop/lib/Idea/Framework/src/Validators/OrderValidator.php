<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Idea\Framework\Validators;

class OrderValidator
{

    private static function checkField($orderData, $field): bool
    {

        if (isset($orderData[$field])) {
            if ($orderData[$field] !== "") {
                return true;
            } else {
                return false;

            }
        } else {
            return false;
        }

    }

    public static function validate($orderData): array
    {

        if (!self::checkField($orderData, 'order_date')) {
            return [
                'result' => false,
                'message' => 'O Campo `order_date` não pode ser vazio'
            ];
        } else if (!self::checkField($orderData, 'code')) {
            return [
                'result' => false,
                'message' => 'O Campo `code` não pode ser vazio'
            ];
        } else if (!self::checkField($orderData, 'total_ordered')) {
            return [
                'result' => false,
                'message' => 'O Campo `total_ordered` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData, 'shipping_cost')) {
            return [
                'result' => false,
                'message' => 'O Campo `shipping_cost` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData, 'channel')) {
            return [
                'result' => false,
                'message' => 'O Campo `channel` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData, 'seller_shipping_cost')) {
            return [
                'result' => false,
                'message' => 'O Campo `seller_shipping_cost` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["customer"], 'vat_number')) {
            return [
                'result' => false,
                'message' => 'O Campo `customer::vat_number` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["customer"], 'name')) {
            return [
                'result' => false,
                'message' => 'O Campo `customer::name` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["customer"], 'email')) {
            return [
                'result' => false,
                'message' => 'O Campo `customer::email` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["customer"], 'date_of_birth')) {
            return [
                'result' => false,
                'message' => 'O Campo `customer::date_of_birth` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["import_info"], 'ss_name')) {
            return [
                'result' => false,
                'message' => 'O Campo `import_info::ss_name` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["import_info"], 'remote_id')) {
            return [
                'result' => false,
                'message' => 'O Campo `import_info::remote_id` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["import_info"], 'remote_code')) {
            return [
                'result' => false,
                'message' => 'O Campo `import_info::remote_code` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["shipping_address"], 'street')) {
            return [
                'result' => false,
                'message' => 'O Campo `shipping_address::street` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["shipping_address"], 'region')) {
            return [
                'result' => false,
                'message' => 'O Campo `shipping_address::region` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["shipping_address"], 'postcode')) {
            return [
                'result' => false,
                'message' => 'O Campo `shipping_address::postcode` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["shipping_address"], 'phone')) {
            return [
                'result' => false,
                'message' => 'O Campo `shipping_address::phone` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["shipping_address"], 'number')) {
            return [
                'result' => false,
                'message' => 'O Campo `shipping_address::number` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["shipping_address"], 'city')) {
            return [
                'result' => false,
                'message' => 'O Campo `shipping_address::city` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["billing_address"], 'street')) {
            return [
                'result' => false,
                'message' => 'O Campo `billing_address::street` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["billing_address"], 'region')) {
            return [
                'result' => false,
                'message' => 'O Campo `billing_address::region` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["billing_address"], 'postcode')) {
            return [
                'result' => false,
                'message' => 'O Campo `billing_address::postcode` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["billing_address"], 'phone')) {
            return [
                'result' => false,
                'message' => 'O Campo `billing_address::phone` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["billing_address"], 'number')) {
            return [
                'result' => false,
                'message' => 'O Campo `billing_address::number` não pode ser vazio'
            ];

        } else if (!self::checkField($orderData["billing_address"], 'city')) {
            return [
                'result' => false,
                'message' => 'O Campo `billing_address::city` não pode ser vazio'
            ];

        } else {

            // Verifica os itens do pedido
            if (is_array($orderData['items'])) {

                foreach ($orderData['items'] as $item) {

                    if (!self::checkField($item, 'special_price')) {
                        return [
                            'result' => false,
                            'message' => 'O Campo `special_price` não pode ser vazio'
                        ];

                    } else if (!self::checkField($item, 'shipping_cost')) {
                        return [
                            'result' => false,
                            'message' => 'O Campo `shipping_cost` não pode ser vazio'
                        ];

                    } else if (!self::checkField($item, 'qty')) {
                        return [
                            'result' => false,
                            'message' => 'O Campo `qty` não pode ser vazio'
                        ];

                    } else if (!self::checkField($item, 'product_id')) {
                        return [
                            'result' => false,
                            'message' => 'O Campo `product_id` não pode ser vazio'
                        ];

                    } else if (!self::checkField($item, 'original_price')) {
                        return [
                            'result' => false,
                            'message' => 'O Campo `original_price` não pode ser vazio'
                        ];

                    } else if (!self::checkField($item, 'name')) {
                        return [
                            'result' => false,
                            'message' => 'O Campo `name` não pode ser vazio'
                        ];

                    } else if (!self::checkField($item, 'id')) {
                        return [
                            'result' => false,
                            'message' => 'O Campo `id` não pode ser vazio'
                        ];
                    }

                }

            } else {
                return [
                    'result' => false,
                    'message' => 'O Campo `itens` não pode ser vazio'
                ];
            }

        }

        // Retorna TRUE em caso de sucesso
        return [
            'result' => true,
        ];


    }


}
