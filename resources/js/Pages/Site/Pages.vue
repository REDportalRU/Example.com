<template>
    <article>

        <!-- start: page -->
        <div class="row employees">
            <div class="col">

                <section class="card  card-big-info">
                    <div class="card-body p-4">
                        <div class="datatables-header-footer-wrapper">
                            <div class="datatable-header">
                                <div class="row align-items-center mb-4">
                                    <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                        <Link href="/page/add"
                                              class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">
                                            + Добавить страницу
                                        </Link>
                                    </div>

                                    <FilterPages
                                        :form="form"
                                        :url="/pages/"/>

                                    <PerPage
                                        :form="form"
                                        :url="/pages/"/>

                                    <Search
                                        :form="form"
                                        :url="/pages/"/>
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
                                    <th v-if="form.filter == 2">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Наименование
                                    </th>
                                    <td v-else>Наименование</td>
                                    <th v-if="form.filter == 3">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Алиас
                                    </th>
                                    <td v-else>Алиас
                                    </td>
                                    <th v-if="form.filter == 4"
                                        class="text-center"
                                        width="12%">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Публикация
                                    </th>
                                    <td v-else
                                        class="text-center"
                                        width="12%">Публикация
                                    </td>
                                    <th v-if="form.filter == 5"
                                        width="10%"
                                        class="text-center">
                                        <i class="fa fa-arrow-down"
                                           aria-hidden="true"></i> Дата добавления
                                    </th>
                                    <td v-else
                                        width="10%"
                                        class="text-center">
                                        Дата добавления
                                    </td>
                                    <th v-if="form.filter == 6"
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

                                <template v-for="page in paginate['data']">
                                    <tr>
                                        <td class="text-center">
                                            {{ page.id }}
                                        </td>
                                        <td>
                                            <Link :href="'/page/update/'+page.id"
                                                  v-tippy="'<b>Редактирование страницы:</b><br><i>' + page.name + '</i>'">
                                                <span style="font-weight: 600">{{ page.name }}</span>
                                            </Link>
                                        </td>
                                        <td>{{ page.alias }}</td>

                                        <td class="text-center">
                                            <label>
                                                <input v-if="getStatus(page.published)"
                                                       v-on:change="checked(page.id, page.published)"
                                                       type="checkbox"
                                                       class="ios-switch tinyswitch"
                                                       checked="checked"/>
                                                <input v-else
                                                       v-on:change="checked(page.id, page.published)"
                                                       type="checkbox"
                                                       class="ios-switch tinyswitch"/>
                                                <div>
                                                    <div></div>
                                                </div>
                                            </label>
                                        </td>

                                        <td class="text-center">{{ getDate(page.created_at) }}</td>
                                        <td class="text-center">{{ getDate(page.updated_at) }}</td>
                                        <td class="text-end">
                                            <Link :href="'/page/update/'+page.id"
                                                  class="me-2">
                                                <i class="bx bx-message-square-edit fa-2x"
                                                   v-tippy="'Редактирование'"></i>
                                            </Link>
                                            <Link v-on:click="deletePage(page.id, page.name)"
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
                                :url="/pages/"
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

export default {
    components: {
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
        }
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
            search: props.search
        })

        /**
         * Изменение статуса публикации соц.сети на сайте
         *                               при клике мышкой
         */
        function checked(id, published) {
            form.post('/page/updatePubliched/' + id + '/' + published)
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
                    form.post('/page/delete/' + id, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        // после получения ответа
                        onFinish: visit => {
                            // Показ успешного уведомления
                            Func.Notify(
                                'success',
                                '<span style="font-size: 1.1rem">Успешно!</span>',
                                '<span style="font-size: .90rem">Страница "' + name + '" удалена.</span>');
                        },
                    })
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Удаление отменено!",
                        text: "Страница '" + name + "' в безопасности :)",
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