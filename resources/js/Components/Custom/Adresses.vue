<template>
    <section class="addresses">
        <h3>Адреса магазинов</h3>

        <div class="addresses__wrapper">
            <!-- Левая колонка с адресами -->
            <div class="addresses__left">
                <ul>
                    <li>
                        <h5>Центр продаж Ташкент - ул. Мукимий 74</h5> <br>
                        <span class="phones">+998 (97) 455 71 54</span>
                        <span class="phones">+998 (97) 455 71 54</span>
                    </li>
                    <li>
                        <h5>Центр продаж, Самарканд - ул. Мирзо Улугбека, 78</h5> <br>
                        <span class="phones">+998 (97) 455 71 54</span>
                        <span class="phones">+998 (97) 455 71 54</span>                    </li>
                    <li>
                        <h5>Сервисный центр Ташкент - ул.
                            Мукимий, 74</h5> <br>
                        <span class="phones">+998 (97) 455 71 54</span>
                        <span class="phones">+998 (97) 455 71 54</span>                    </li>
                </ul>
            </div>

            <!-- Правая колонка с картой -->
            <div class="addresses__right">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2998.156936782149!2d69.23602309999998!3d41.283688799999986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8a5ec5f7584f%3A0xfebedb2d48284dcd!2sMukimi%20Street%2074%2C%20Tashkent%2C%20Uzbekistan!5e0!3m2!1sen!2s!4v1765362715807!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Addresses',
}
</script>

<style scoped>
h3{
    font-size: 24px;
    color: #333333;
    font-weight: 400;
    padding: 40px 10px;
}
.addresses {
    margin: 0 auto;
    max-width: 1260px;
    padding: 20px 10px;
    border-top: 1px solid #ccc;
}

.addresses__wrapper {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
    border: 1px solid #eee;
}

.addresses__left {
    flex: 1;

}

.addresses__left h3 {
    font-size: 18px;
    margin-bottom: 20px;
}

.addresses__left ul {
    list-style: none;
    padding: 0;
    color: #666666;
    font-size: 15px;
}
.addresses__left h5{
    font-size: 14px;
    font-weight: 400;
    color: #333333;
}
.addresses__left span{
    display: block;
    font-size: 13px;
    color: #999999;
}

.addresses__left li {
    border-bottom: 1px solid #eee;
    padding: 30px 10px 10px 30px;
}

.addresses__left strong {
    color: #333333;
    font-weight: 400;
}

.addresses__right {
    flex: 3;
    height: 444px;
    border-radius: 8px;
    overflow: hidden;
}
iframe{
    width:100%;
}
@media (max-width: 600px) {
    .addresses__wrapper{
        flex-direction: column;
    }

}
</style>
