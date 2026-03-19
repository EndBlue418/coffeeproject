<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>著名咖啡風味比較 (30種, 懸浮細節)</title>
    <style>
        /* --- 基礎樣式 (不變) --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4a2c2a;
            border-bottom: 3px solid #6f4e37;
            padding-bottom: 10px;
        }
        .filter-buttons {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px dashed #a38b7e;
            border-radius: 8px;
            background-color: #e9e5e0;
        }
        .filter-buttons button {
            padding: 10px 15px;
            margin-right: 10px;
            margin-bottom: 5px;
            background-color: #a38b7e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .filter-buttons button:hover {
            background-color: #6f4e37;
        }
        .filter-buttons button.recommend-btn {
            background-color: #376f4e; 
        }
        .filter-buttons button.recommend-btn:hover {
            background-color: #2c4a3c;
        }

        /* --- 九宮格佈局 (Grid) --- */
        #coffeeList {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
        }
        .coffee-item {
            position: relative; 
            /* 固定卡片高度，避免佈局跳動 */
            height: 250px; 
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* 必須使用 overflow: hidden; 來裁切懸浮時溢出的內容，避免卡片重疊 */
            overflow: hidden; 
            transition: all 0.3s ease; 
            cursor: pointer;
        }
        
        .coffee-item.hidden {
            display: none !important; 
        }

        /* --- 懸浮動效 --- */
        .coffee-item:hover {
            transform: scale(1.03); 
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); 
            border: 2px solid #6f4e37; 
        }
        .coffee-item:hover .coffee-name {
            background-color: #4a2c2a; 
        }

        /* 咖啡名稱 (初始佔滿卡片) */
        .coffee-name {
            background-color: #6f4e37;
            color: white;
            padding: 15px;
            font-size: 1.2em;
            display: flex;
            justify-content: center; 
            align-items: center;
            height: 100%; 
            transition: all 0.3s ease;
            position: relative; 
            z-index: 10;
        }
        
        /* 詳細資訊區塊 - 初始隱藏 */
        .flavor-details {
            position: absolute;
            top: 100%; /* 初始位置在卡片下方 */
            left: 0;
            width: 100%;
            padding: 15px;
            background-color: #fffaf0;
            opacity: 0; 
            transform: translateY(0); 
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
            z-index: 5;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* 懸浮時，名稱縮小，詳細資訊滑入 */
        .coffee-item:hover .coffee-name {
            height: 40px; 
        }
        .coffee-item:hover .flavor-details {
            top: 60px; 
            opacity: 1; 
            /* 為細節內容設置最大可視高度，並啟用捲軸 */
            max-height: 160px; /* 220px - 60px (名稱高度) = 160px */
            overflow-y: auto;
        }

        /* 詳細資訊內文樣式 (不變) */
        .flavor-details p {
            margin: 5px 0;
            color: #333;
        }
        .flavor-details strong {
            color: #6f4e37;
        }
        .star {
            color: gold;
            font-size: 1.2em;
        }
        .toggle-icon {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>☕ 著名咖啡風味比較 (30種)</h1>

    <?php
    // --- PHP 數據定義 (30 種) ---
    $coffees = [
        // 基礎及經典款 (8種)
        "阿拉比卡 (Arabica)" => ["苦澀度" => 2, "酸味" => 4, "口感/醇度" => 3, "介紹" => "全球最常見、品質最好的品種。風味細膩多變，具有怡人的果酸和香氣。"],
        "羅布斯塔 (Robusta)" => ["苦澀度" => 5, "酸味" => 1, "口感/醇度" => 4, "介紹" => "咖啡因含量高，口感強勁苦澀。常用於混合豆，以增加濃縮咖啡的油脂。"],
        "曼特寧 (Mandheling)" => ["苦澀度" => 4, "酸味" => 1, "口感/醇度" => 5, "介紹" => "來自印尼蘇門答臘，以其厚重、低酸的特性聞名。帶有泥土、草本或黑巧克力的風味。"],
        "耶加雪菲 (Yirgacheffe)" => ["苦澀度" => 1, "酸味" => 5, "口感/醇度" => 2, "介紹" => "著名的衣索比亞水洗豆。風味極為明亮，帶有清晰的柑橘酸和優雅的花香。"],
        "藍山咖啡 (Blue Mountain)" => ["苦澀度" => 1, "酸味" => 3, "口感/醇度" => 3, "介紹" => "牙買加極品，以其極致的平衡感著稱，酸苦適中，風味溫和且乾淨。"],
        "肯亞 AA (Kenya AA)" => ["苦澀度" => 2, "酸味" => 5, "口感/醇度" => 3, "介紹" => "以其複雜且多汁的果酸聞名，酸味強烈但高雅，常帶有黑醋栗的風味。"],
        "哥倫比亞 薇拉 (Huila)" => ["苦澀度" => 2, "酸味" => 3, "口感/醇度" => 3, "介紹" => "經典的哥倫比亞水洗豆，具有很好的平衡性、適中的酸度和焦糖甜感。"],
        "巴西 喜拉朵 (Cerrado)" => ["苦澀度" => 3, "酸味" => 2, "口感/醇度" => 4, "介紹" => "巴西知名產區，口感醇厚且酸度低，風味常帶有堅果和巧克力的基調。"],
        
        // 中美洲及加勒比海 (7種)
        "瓜地馬拉 安提瓜" => ["苦澀度" => 3, "酸味" => 4, "口感/醇度" => 4, "介紹" => "火山灰土壤，風味帶有煙燻、香料或黑巧克力，酸度明亮而乾淨。"],
        "宏都拉斯 水洗" => ["苦澀度" => 2, "酸味" => 3, "口感/醇度" => 3, "介紹" => "經典的中美洲風味，乾淨、明亮，帶有核果和奶油巧克力的尾韻。"],
        "哥斯大黎加 塔拉珠" => ["苦澀度" => 2, "酸味" => 4, "口感/醇度" => 3, "介紹" => "高海拔水洗豆，口感平衡、酸度乾淨且明亮，帶有柑橘和蜂蜜的甜感。"],
        "薩爾瓦多 (El Salvador)" => ["苦澀度" => 3, "酸味" => 3, "口感/醇度" => 4, "介紹" => "口感醇厚順滑，酸度柔和，常帶有牛奶巧克力和堅果的甜味。"],
        "尼加拉瓜 (Nicaragua)" => ["苦澀度" => 2, "酸味" => 3, "口感/醇度" => 3, "介紹" => "風味乾淨，酸度溫和，帶有花香和柑橘氣息。"],
        "夏威夷 可娜 (Kona)" => ["苦澀度" => 2, "酸味" => 3, "口感/醇度" => 3, "介紹" => "美國唯一產區。口感順滑且乾淨，風味平衡，帶有堅果或香料的甜美感。"],
        "巴拿馬 藝伎 (Geisha)" => ["苦澀度" => 1, "酸味" => 5, "口感/醇度" => 1, "介紹" => "頂級咖啡代表。以其極為複雜的茉莉花香、荔枝甜和纖細的茶感聞名。"],
        
        // 非洲特色款 (7種)
        "衣索比亞 日曬 西達摩" => ["苦澀度" => 1, "酸味" => 4, "口感/醇度" => 3, "介紹" => "採用日曬處理，帶有強烈的莓果發酵香氣和甜感，口感較為圓潤。"],
        "衣索比亞 谷吉 (Guji)" => ["苦澀度" => 1, "酸味" => 5, "口感/醇度" => 2, "介紹" => "高品質水洗豆，具有檸檬皮、桃子和紅茶的風味。"],
        "盧安達 (Rwanda)" => ["苦澀度" => 2, "酸味" => 4, "口感/醇度" => 3, "介紹" => "口感活潑，帶有柑橘、紅蘋果酸和焦糖甜。有時略帶香料感。"],
        "蒲隆地 (Burundi)" => ["苦澀度" => 1, "酸味" => 5, "口感/醇度" => 2, "介紹" => "非洲精品豆，通常有鮮明的花香、紅茶感和果汁般的酸甜平衡。"],
        "坦尚尼亞 乞力馬扎羅" => ["苦澀度" => 3, "酸味" => 4, "口感/醇度" => 4, "介紹" => "口感飽滿，酸度活躍，帶有黑莓和焦糖味。"],
        "馬拉威 (Malawi)" => ["苦澀度" => 2, "酸味" => 3, "口感/醇度" => 3, "介紹" => "風味細緻，帶有花香、柑橘和堅果調性，口感溫和。"],
        "葉門 摩卡 (Mocha)" => ["苦澀度" => 3, "酸味" => 3, "口感/醇度" => 3, "介紹" => "歷史最悠久的咖啡。風味常帶有巧克力和葡萄酒般的酸度。"],
        
        // 亞洲及商業調配 (8種)
        "印尼 蘇拉維西 托拉雅" => ["苦澀度" => 4, "酸味" => 2, "口感/醇度" => 5, "介紹" => "口感厚重、醇度極佳，酸度低。類似曼特寧，但帶有一絲香料或辛辣味。"],
        "印尼 爪哇 (Java)" => ["苦澀度" => 4, "酸味" => 2, "口感/醇度" => 4, "介紹" => "經典的亞洲重口味咖啡，低酸度，帶有香料和泥土的風味。"],
        "越南 羅布斯塔" => ["苦澀度" => 5, "酸味" => 1, "口感/醇度" => 5, "介紹" => "常用於越南咖啡滴濾。極高苦澀度、極低酸度，醇厚度強勁。"],
        "印度 季風馬拉巴" => ["苦澀度" => 4, "酸味" => 1, "口感/醇度" => 5, "介紹" => "經過特殊季風處理，幾乎沒有酸味，口感厚重，帶有泥土和堅果香氣。"],
        "義式濃縮綜合豆" => ["苦澀度" => 4, "酸味" => 2, "口感/醇度" => 5, "介紹" => "通常是深度烘焙的綜合豆。專為 Espresso 設計，強調濃郁、油脂和苦甜平衡。"],
        "法式烘焙綜合豆" => ["苦澀度" => 5, "酸味" => 1, "口感/醇度" => 4, "介紹" => "極深烘焙，油光發亮。風味極苦，帶有強烈的碳烤和焦糖味。"],
        "低咖啡因 (Decaf)" => ["苦澀度" => 3, "酸味" => 3, "口感/醇度" => 3, "介紹" => "經水洗或化學處理移除咖啡因，風味通常較為柔和，保留原始特性。"],
        "黃金曼特寧 (Giling Basah)" => ["苦澀度" => 4, "酸味" => 1, "口感/醇度" => 5, "介紹" => "半水洗處理法的曼特寧，口感更為乾淨和甜美，仍保持低酸度與高醇度。"]
    ];

    function get_stars($count) {
        $stars = str_repeat('<span class="star">★</span>', $count);
        return $stars;
    }
    
    $coffee_ids = [];
    $index = 0;
    foreach ($coffees as $name => $data) {
        $index++;
        $coffee_ids[] = "coffee-" . $index;
    }
    $js_coffee_ids = json_encode($coffee_ids);
    ?>

    <div class="filter-buttons">
        <strong>喜好篩選：</strong>
        <button onclick="filterCoffees('bitterness', 4)">喜歡苦味 (≥ 4星苦澀度)</button>
        <button onclick="filterCoffees('acidity', 4)">喜歡酸味 (≥ 4星酸味)</button>
        <button onclick="filterCoffees('body', 4)">喜歡濃郁 (≥ 4星醇度)</button>
        <button onclick="filterCoffees('all')">顯示全部</button>
        <button class="recommend-btn" onclick="randomRecommend()">✨ 隨機推薦</button>
    </div>

    <div id="coffeeList">
    <?php
    $index = 0;
    foreach ($coffees as $name => $data) {
        $index++;
        $id = "coffee-" . $index; 
        
        $data_attributes = "data-bitterness='{$data['苦澀度']}' data-acidity='{$data['酸味']}' data-body='{$data['口感/醇度']}'";
        ?>

        <div class="coffee-item" id="<?php echo $id; ?>-item" <?php echo $data_attributes; ?>>
            <div class="coffee-name"> 
                <?php echo $name; ?>
            </div>

            <div id="<?php echo $id; ?>" class="flavor-details">
                <p><strong>苦澀度 (5星最苦):</strong> <?php echo get_stars($data['苦澀度']); ?></p>
                <p><strong>酸味 (5星最酸):</strong> <?php echo get_stars($data['酸味']); ?></p>
                <p><strong>口感/醇度 (5星最濃郁):</strong> <?php echo get_stars($data['口感/醇度']); ?></p>
                <p>---</p>
                <p><strong>介紹:</strong> <?php echo $data['介紹']; ?></p>
            </div>
        </div>

    <?php
    }
    ?>
    </div>
</div>

<script>
    const ALL_COFFEE_IDS = <?php echo $js_coffee_ids; ?>;

    function toggleDetails(id) {}
    function collapseAllExcept(excludeId = null) {}

    /**
     * 篩選咖啡列表，根據指定屬性和最低星級
     */
    function filterCoffees(filterType, minStars = 0) {
        const coffeeItems = document.querySelectorAll('.coffee-item');
        
        const dataAttributeMap = {
            'bitterness': 'data-bitterness',
            'acidity': 'data-acidity',
            'body': 'data-body'
        };

        coffeeItems.forEach(item => {
            item.classList.remove('hidden'); 

            if (filterType === 'all') {
                return;
            }

            const attributeName = dataAttributeMap[filterType];
            const starValue = parseInt(item.getAttribute(attributeName));

            if (starValue < minStars) {
                item.classList.add('hidden');
            }
        });
    }

    /**
     * 隨機推薦一個咖啡項目
     */
    function randomRecommend() {
        filterCoffees('all');

        const randomIndex = Math.floor(Math.random() * ALL_COFFEE_IDS.length);
        const recommendedId = ALL_COFFEE_IDS[randomIndex];
        const recommendedItem = document.getElementById(recommendedId + '-item');

        const coffeeItems = document.querySelectorAll('.coffee-item');
        coffeeItems.forEach(item => {
            item.classList.add('hidden');
        });
        
        if (recommendedItem) {
            recommendedItem.classList.remove('hidden');
            recommendedItem.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>

</body>
</html>