<?php

namespace app\modules\account\models;

use Yii;

class UserExtra extends BaseUserExtra
{
    public static $options = [
        'sex' => [
            '1' => 'Nam',
            '2' => 'Nữ',
            'Gay và chuyển Nam' => [
                '3' => 'Gay BOT',
                '4' => 'Gay TOP',
                '5' => 'Chuyển giới thành Nam',
            ],
            'Lessbian - Chuyển nữ' => [
                '6' => 'Lessbian FEM',
                '7' => 'Lessbian SB',
                '8' => 'Chuyển giới thành Nữ',
            ],
        ],
        'housing' => ['Sống với bố mẹ', 'Thuê nhà', 'Có nhà riêng', 'Ở nhà công ty', 'Ở nhà bố mẹ (không sống chung với bố mẹ)'],
        'marriage' => ['Chưa kết hôn', 'Đã ly thân', 'Đã ly dị', 'Chồng mất/Vợ mất'],
        'religion' => ['Không tôn giáo', 'Phật giáo', 'Thiên chúa giáo', 'Nho giáo', 'Đạo hồi', 'Đạo tiên lành', 'Cơ đốc giáo'],
        'interest' => [
            'music' => 'Interesting music',
            'song' => 'Interesting song',
            'cuisine' => 'Interesting cuisine',
            'food' => 'Interesting food',
            'film_genre' => 'Interesting film genre',
            'film' => 'Interesting film',
            'sport' => 'Interesting sport',
        ],
    ];
    
    public function rules() {
        $data = [
            [['height', 'weight'], 'integer'],
        ];
        return array_merge(parent::rules(), $data);
    }
}
