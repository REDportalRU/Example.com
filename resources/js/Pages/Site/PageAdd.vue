<template>
    <form @submit.prevent="savePage"
          class="ecommerce-form action-buttons-fixed">

        <section class="card card-big-info">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-2-5 col-xl-1-5">
                        <i class="bx bx-user-circle fa-7x" style="color: #ddd"></i>
                        <h2 class="card-big-info-title">Информация о странице</h2>
                        <p class="card-big-info-desc">Добавьте сюда информацию о странице со всеми
                                                      деталями и необходимой информацией.</p>
                    </div>
                    <div class="col-lg-3-5 col-xl-4-5">

                        <div class="row">
                            <div class="col-xl-3 col-12 text-xl-end pt-2">
                                Наименование
                                <span style="color: red"><b>*</b></span>
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="input-group mb-3">
                                    <input v-model="form.name"
                                           type="text"
                                           class="form-control"
                                           required
                                           autocomplete="name"
                                           data-plugin-maxlength=""
                                           maxlength="150"
                                           v-tippy="{content:'Наименование страницы', placement:'right'}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-12 text-xl-end pt-2">
                                Alias
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="input-group mb-3">
                                    <input v-model="form.alias"
                                           type="text"
                                           class="form-control"
                                           autocomplete="alias"
                                           data-plugin-maxlength=""
                                           maxlength="150"
                                           v-tippy="{content:'Алиас страницы<br><i>если не заполнять, то создаётся автоматически</i>', placement:'right'}">
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-xl-3 col-12 text-xl-end pt-2">
                                Публикация категории
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="input-group mb-3">
                                    <label v-tippy="{content:'Опубликовать страницу на сайте', placement:'right'}">
                                        <input v-model="form.published"
                                               type="checkbox"
                                               class="ios-switch tinyswitch"/>
                                        <div>
                                            <div></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="card card-big-info">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-2-5 col-xl-1-5">
                        <i class="bx bx-message-alt-detail fa-7x" style="color: #ddd"></i>
                        <h2 class="card-big-info-title">Тект страницы</h2>
                        <p class="card-big-info-desc">Добавьте сюда текстовку страницы.</p>
                    </div>
                    <div class="col-lg-3-5 col-xl-4-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <ckeditor :editor="editor"
                                              v-model="form.text"
                                              :config="editorConfig"></ckeditor>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section v-if="user['role_id'] == 1"
                 class="card card-big-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2-5 col-xl-1-5">
                        <i class="bx bx-line-chart fa-7x" style="color: #ddd"></i>
                        <h2 class="card-big-info-title">SEO информация</h2>
                        <p class="card-big-info-desc">Добавьте сюда SEO информацию о странице.</p>
                    </div>
                    <div class="col-lg-3-5 col-xl-4-5">

                        <div class="row form-group py-2">
                            <div class="col-xl-2 col-12 text-xl-end pt-2">
                                Title
                            </div>
                            <div class="col-xl-10 col-12">
                                <input v-model="form.titlePage"
                                       type="text"
                                       class="form-control"
                                       data-plugin-maxlength=""
                                       maxlength="190"
                                       autocomplete="title"
                                       v-tippy="{content:'<b>Текст в метатеге TITLE должен описывать название страницы.</b><br><i>Учитывается поисковыми системами.<br>По заголовку должно быть понятно, о чём эта страница, даже когда она не открыта в браузере, а отображается в результатах поиска или в браузерных закладках.</i>', placement:'right'}">
                            </div>
                        </div>

                        <div class="row form-group py-2">

                            <div class="col-xl-2 col-12 text-xl-end pt-2">
                                Description
                            </div>
                            <div class="col-xl-10 col-12">
                                        <textarea v-model="form.descriptionPage"
                                                  class="form-control"
                                                  rows="3"
                                                  data-plugin-maxlength=""
                                                  maxlength="190"
                                                  v-tippy="{content:'Большинство поисковых систем отображают содержимое метатега DESCRIPTION при выводе результатов поиска', placement:'right'}"></textarea>
                            </div>
                        </div>

                        <div class="row form-group py-2">
                            <div class="col-xl-2 col-12 text-xl-end pt-2">
                                Keywords
                            </div>
                            <div class="col-xl-10 col-12">
                                <div class="input-group mb-3">
                                    <input v-model="form.keywordsPage"
                                           type="text"
                                           class="form-control"
                                           data-plugin-maxlength=""
                                           maxlength="190"
                                           autocomplete="name"
                                           v-tippy="{content:'<b>Метатег KEYWORDS предназначен для описания ключевых слов, встречающихся на странице.</b><br><i>Ключевые слова должны быть разделены запятыми.</i>', placement:'right'}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <div class="row action-buttons pt-4">
            <div class="col-12 col-md-auto">
                <button type="submit"
                        class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1 text-uppercase"
                        data-loading-text="Loading...">
                    <i class="bx bx-save text-4 me-2"></i> Сохранить
                </button>
            </div>
            <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                <button type="button" onclick="javascript:history.back(); return false;"
                        class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3 text-uppercase">Назад
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import {Link, useForm} from "@inertiajs/vue3"
import Layout from "@/Layout/Layout.vue"
import {Func} from "@/Mixins/Functions.js"
import ClasicEditor from "@ckeditor/ckeditor5-build-classic"

export default {
    components: {
        Link,
        Layout,
    },
    props: {
        user: Array,
    },
    data(props) {
        return {
            editor: ClasicEditor,
            editorConfig: {
                mediaEmbed: {previewsInData: true},
                link: {
                    decorators: {
                        addTargetToExternalLinks: {
                            mode: 'automatic',
                            callback: url => /^(https?:)?\/\//.test(url),
                            attributes: {
                                target: '_blank',
                                rel: 'noopener noreferrer nofollow'
                            }
                        }
                    }
                }
            },
        }
    },
    methods: {},
    mounted() {

    },
    setup(props) {
        /**
         * Реактивная формам
         */
        const form = useForm({
            name: '',
            alias: '',
            text: '',
            titlePage: '',
            descriptionPage: '',
            keywordsPage: '',
            published: 1,
        })

        /**
         * преобразование значений в bool
         * @type {boolean}
         */
        form.published = getStatus(form.published)

        /**
         * Отправка формы
         */
        function savePage() {
            form.post('/page/add', {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                // после получения ответа
                onFinish: visit => {
                    // если есть ошибки
                    if (form.hasErrors) {
                        // перебор объекта с ощибками
                        for (let key in form.errors) {
                            // Показ уведомления с ошибкой
                            Func.Notify(
                                'error',
                                '<span style="font-size: 1.1rem">Ошибка!</span>',
                                '<span style="font-size: .90rem">' + form.errors[key] + '</span>')
                        }
                    } else {
                        // Показ успешного уведомления
                        Func.Notify(
                            'success',
                            '<span style="font-size: 1.1rem">Успешно!</span>',
                            '<span style="font-size: .90rem">Новая страница сохранена.</span>')
                    }
                },
            })
        }

        function getStatus(val) {
            if (val != 0) {
                return true
            } else {
                return false
            }
        }

        return {form, savePage, getStatus}
    },
    layout: Layout
}
</script>

<style scoped>
</style>