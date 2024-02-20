<template>
    <article>

        <!-- start: page -->
        <div class="row">
            <div class="col">

                <section class="card card-big-info">
                    <div class="card-body p-4">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-4">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <Link href="/news/add"
                                              class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">
                                            + Добавить новость
                                        </Link>
                                    </div>

                                    <FilterNews
                                        :form="form"
                                        :url="/news/"/>

                                    <PerPage
                                        :form="form"
                                        :url="/news/"/>

                                    <Search
                                        :form="form"
                                        :url="/news/"/>
                                </div>
                            </div>

                            <table class="table table-ecommerce-simple table-striped mb-0"
                                   id="datatable-ecommerce-list"
                                   style="min-width: 750px;">

                                <thead>
                                <tr>
                                    <th v-if="form.filter == 1"
                                        width="5%"
                                        class="text-center">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> ID
                                    </th>
                                    <td v-else
                                        width="5%"
                                        class="text-center">
                                        ID
                                    </td>
                                    <td></td>
                                    <th v-if="form.filter == 2">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Наименование
                                    </th>
                                    <td v-else>Наименование</td>

                                    <td width="15%" class="px-2">Категории</td>

                                    <th v-if="form.filter == 4"
                                        width="7%"
                                        class="text-center">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Просмотры
                                    </th>
                                    <td v-else width="7%">Просмотры</td>
                                    <th v-if="form.filter == 5"
                                        class="text-center"
                                        width="7%">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Публикация
                                    </th>
                                    <td v-else
                                        class="text-center"
                                        width="7%">Публикация
                                    </td>
                                    <th v-if="form.filter == 6"
                                        width="10%"
                                        class="text-center">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Дата публикации
                                    </th>
                                    <td v-else
                                        width="10%"
                                        class="text-center">
                                        Дата публикации
                                    </td>
                                    <th v-if="form.filter == 7"
                                        width="10%"
                                        class="text-center">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Дата обновления
                                    </th>
                                    <td v-else
                                        width="10%"
                                        class="text-center">
                                        Дата обновления
                                    </td>
                                    <td width="8%"></td>
                                </tr>
                                </thead>
                                <tbody>

                                <template v-for="news in paginate['data']">
                                    <tr>
                                        <td class="text-center">
                                            {{ news.id }}
                                        </td>
                                        <td>
                                            <Link :href="'/news/update/'+news.id">
                                                <img :src="news.main_image"
                                                     style="max-width: 70px; max-height: 70px; margin: 5px 0; border-radius: 5px">
                                            </Link>
                                        </td>
                                        <td>
                                            <Link :href="'/news/update/'+news.id"
                                                  v-tippy="'<b>Редактирование новости:</b><br><i>' + news.name + '</i>'">
                                                <span style="font-weight: 600">{{ news.name }}</span>
                                            </Link>
                                        </td>
                                        <td>
                                            <template v-for="cat in getCategory(news.categories_id)">
                                                <div class="my-1 px-2 border background-color-tertiary
                                                 text-white rounded-3">
                                                    <template v-for="cat_name in getCatName(cat)">
                                                        <i>{{ cat_name }}</i>
                                                    </template>
                                                </div>
                                            </template>
                                        </td>
                                        <td class="text-center">{{ news.hits }}</td>
                                        <td class="text-center">
                                            <label>
                                                <input v-if="getStatus(news.published)"
                                                       v-on:change="checked(news.id, news.published)"
                                                       type="checkbox"
                                                       class="ios-switch tinyswitch"
                                                       checked="checked"/>
                                                <input v-else
                                                       v-on:change="checked(news.id, news.published)"
                                                       type="checkbox"
                                                       class="ios-switch tinyswitch"/>
                                                <div>
                                                    <div></div>
                                                </div>
                                            </label>
                                        </td>

                                        <td class="text-center" v-html="dateNews(news.created_at)"></td>
                                        <td class="text-center" v-html="getDate(news.updated_at) + '<br>' + getTime(news.updated_at)"></td>
                                        <td class="text-end">
                                            <Link :href="'/news/update/'+news.id"
                                                  class="me-2">
                                                <i class="bx bx-message-square-edit fa-2x"
                                                   v-tippy="'Редактирование'"></i>
                                            </Link>
                                            <Link v-on:click="deletePage(news.id, news.name)"
                                                  class="text-danger">
                                                <i class="bx bx-message-square-x fa-2x"
                                                   v-tippy="'Удаление'"></i>
                                            </Link>
                                        </td>
                                    </tr>
                                </template>

                                </tbody>
                            </table>

                            <!-- from - показано С  -->
                            <!-- to - показано ПО -->
                            <!-- total - показано ИЗ -->
                            <!-- maxVisibleButtons - кол-во отображаемых страниц -->
                            <!-- lastPage - всего страниц -->
                            <!-- currentPage - текущая страница -->
                            <Paginate
                                :from="paginate.from"
                                :to="paginate.to"
                                :total="paginate.total"
                                :maxVisibleButtons="2"
                                :lastPage="paginate.last_page"
                                :currentPage="currentPage"
                                @pagechanged="onPageChange"
                                :perPage="form.perPage"
                                :filter="form.filter"
                                :activePage="form.activePage"
                                :form="form"
                                :url="/news/"
                            />

                        </div>
                    </div>

                </section>
            </div>
            <!-- end: page -->
        </div>

    </article>
</template>

<script>
import {Link, useForm} from "@inertiajs/vue3"
import Layout from "@/Layout/Layout.vue"
import {Func} from "@/Mixins/Functions.js"
import PerPage from "@/Components/Construct/Filters/PerPage.vue"
import Search from "@/Components/Construct/Filters/Search.vue"
import Paginate from "@/Components/Construct/Paginate/Paginate.vue"
import FilterPages from "@/Components/Construct/Filters/FilterPages.vue"
import FilterNews from "@/Components/Construct/Filters/FilterNews.vue"

export default {
    components: {
        FilterNews,
        FilterPages,
        Link,
        Layout,
        Func,
        PerPage,
        Search,
        Paginate,
    },
    props: {
        url_app: String,
        perPage: Number,
        filter: String,
        activePage: Number,
        search: String,
        paginate: Object,
        categories: Array,
        category: Number,
    },
    data(props) {
        return {
            currentPage: props.paginate.current_page,
        }
    },
    methods: {
        /**
         * Отключает кнопку активной страницы
         * @param page
         */
        onPageChange(page) {
            this.currentPage = page;
        },
        getDate(val) {
            return Func._date(val)
        },
        getTime(val) {
            return Func._time_mini(val, 3)
        },
        dateNews(val) {
            return Func._dateNews(val, 3)
        },
        getCategory(categories_id) {
            return JSON.parse(categories_id)
        },
        getCatName(categories_id) {
            console.log(Object.values(categories_id)[1])
            return Object.values(categories_id)[1]
        },
    },
    computed: {},
    mounted() {
    },
    setup(props) {
        /**
         * Реактивная формам
         */
        const form = useForm({
            perPage: props.perPage,
            filter: props.filter,
            activePage: props.activePage,
            search: props.search,
            categories: props.categories,
            category: props.category,
        })

        /**
         * Изменение статуса публикации новости на сайте
         *                               при клике мышкой
         */
        function checked(id, published) {
            form.post('/news/updatePubliched/' + id + '/' + published)
        }

        function deletePage(id, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Вы уверены?",
                text: "После удаления Вы не сможете это отменить!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Удалить!",
                cancelButtonText: "Не удалять!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // отправка формы
                    form.post('/news/delete/' + id, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        // после получения ответа
                        onFinish: visit => {
                            // Показ успешного уведомления
                            Func.Notify(
                                'success',
                                '<span style="font-size: 1.1rem">Успешно!</span>',
                                '<span style="font-size: .90rem">Новость "' + name + '" удалена.</span>');
                        },
                    })
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Удаление отменено!",
                        text: "Новость '" + name + "' в безопасности :)",
                        icon: "error"
                    });
                }
            });
        }

        function getStatus(val) {
            if (val != 0) {
                return true
            } else {
                return false
            }
        }

        return {form, checked, deletePage, getStatus}
    },
    layout: Layout
}
</script>

<style scoped>
td {padding: 1px 5px;}
</style>