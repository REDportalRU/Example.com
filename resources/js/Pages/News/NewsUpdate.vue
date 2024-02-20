<template>
    <form @submit.prevent="updateNews"
          class="ecommerce-form action-buttons-fixed">

        <section class="card card-big-info">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-2-5 col-xl-1-5">
                        <i class="bx bx-book-open fa-7x" style="color: #ddd"></i>
                        <h2 class="card-big-info-title">Информация о новости</h2>
                        <p class="card-big-info-desc">Добавьте сюда информацию о новости со всеми
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
                                           v-tippy="{content:'Наименование новости', placement:'right'}">
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
                                           v-tippy="{content:'Алиас новости<br><i>если не заполнять, то создаётся автоматически</i>', placement:'right'}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-12 text-xl-end pt-2">
                                Категория
                                <span style="color: red"><b>*</b></span>
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="input-group mb-3">
                                    <MultiSelect
                                        v-model="form.categories_id"
                                        :options="form.categories"
                                        filter
                                        optionLabel="name"
                                        placeholder="Выбрать категорию..."
                                        :maxSelectedLabels="3"
                                        class="w-full md:w-40rem"
                                        v-tippy="{content:'Категории, к которым будет привязана новость<br><i>можно выбрать несколько (CTRL+ЛКМ)</i>', placement:'right'}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-12 text-xl-end pt-2">
                                Теги
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="input-group mb-3">
                                    <MultiSelect
                                        v-model="form.tags_id"
                                        :options="form.tags"
                                        filter
                                        optionLabel="name"
                                        placeholder="Выбрать теги..."
                                        :maxSelectedLabels="3"
                                        class="w-full md:w-40rem"
                                        v-tippy="{content:'Теги, которые будут привязаны к новости<br><i>можно выбрать несколько (CTRL+ЛКМ)</i>', placement:'right'}"/>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-xl-3 col-12 text-xl-end pt-2">
                                Дата
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="input-group mb-3"
                                     v-tippy="{content:'Дата публикации новости<br><i></i>если не заполнять, то будут установлены текущие дата и время', placement:'right'}">
                                    <input v-model="form.dateNews"
                                           type="date"
                                           class="form-control">
                                    <transition name="fade">
                                        <template v-if="form.dateNews">
                                            <input v-model="form.timeNews"
                                                   type="time"
                                                   min="03:00:00"
                                                   max="23:59:59"
                                                   step="1"
                                                   class="form-control">
                                        </template>
                                    </transition>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom mt-2 mb-3"></div>
                        <div class="row">
                            <div class="col-xl-3 col-12 text-xl-end pt-2">
                                Публикация новости
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="input-group mb-3">
                                    <label v-tippy="{content:'Опубликовать новость на сайте', placement:'right'}">
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
                        <i class="bx bx-image-alt fa-7x" style="color: #ddd"></i>
                        <h2 class="card-big-info-title">Главное изображение</h2>
                        <p class="card-big-info-desc">Добавьте сюда главное изображение новости.</p>
                    </div>
                    <div class="col-lg-3-5 col-xl-4-5">
                        <div class="row form-group">
                            <div class="col-xl-3 col-12 text-xl-end pt-2">
                                Изображение
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <div class="fileupload fileupload-new"
                                     data-provides="fileupload">
                                    <input type="hidden"
                                           name="logo">
                                    <div class="input-append">
                                        <div class="uneditable-input">

                                            <span class="fileupload-preview px-0"></span>
                                        </div>
                                        <span class="btn btn-default btn-file"
                                              v-tippy="{content: 'Замена главного изображения новости, которое отображается в блоках новостей', placement: 'right'}">
                                            <span class="fileupload-exists">Изменить</span>
                                            <span class="fileupload-new">Выбрать файл</span>
                                            <input v-on:input="uploadLogo(form)"
                                                   multiple
                                                   tabindex="-1"
                                                   type="file"
                                                   ref="file"
                                                   name="logo">
                                        </span>
                                        <!-- <a href="#" -->
                                        <!-- class="btn btn-default fileupload-exists" -->
                                        <!-- data-dismiss="fileupload"> -->
                                        <!-- Удалить -->
                                        <!-- </a> -->

                                        <div v-if="form.main_image">
                                            <div class="mt-4 w-100 px-3 py-1 background-color-dark text-white"
                                                 v-html="'Текущее главное изображение:'"></div>
                                            <img :src="form.main_image"
                                                 ref="img"
                                                 class="px-3 py-3"
                                                 style="max-height: 350px; max-width: 100%">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class=" card card-big-info">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-2-5 col-xl-1-5">
                        <i class="bx bx-message-alt-detail fa-7x" style="color: #ddd"></i>
                        <h2 class="card-big-info-title">Тект новости</h2>
                        <p class="card-big-info-desc">Добавьте сюда текстовку новости.</p>
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
                                       v-tippy="{content:'<b>Текст в метатеге TITLE должен описывать название страницы.</b><br><i>Учитывается поисковыми системами.<br>По заголовку должно быть понятно, о чём эта страница, даже когда она не открыта в браузере, а отображается в результатах поиска или в браузерных закладках.</i>', placement:'right'}"
                                       autocomplete="title">
                            </div>
                        </div>

                        <div class="row form-group py-2">

                            <div class="col-xl-2 col-12 text-xl-end pt-2">
                                Description
                            </div>
                            <div class="col-xl-10 col-12">
                                        <textarea v-model="form.descriptionPage"
                                                  class="form-control"
                                                  rows="5"
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
                                           v-tippy="{content:'<b>Метатег KEYWORDS предназначен для описания ключевых слов, встречающихся на странице.</b><br><i>Ключевые слова должны быть разделены запятыми.</i>', placement:'right'}"
                                           autocomplete="name">
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
            <div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto">
                <button v-on:click="deleteNews"
                        type="button"
                        class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1 text-uppercase">
                    <i class="bx bx-trash text-4 me-2"></i> Удалить
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
import MultiSelect from 'primevue/multiselect'

export default {
    components: {
        Link,
        Layout,
        MultiSelect,
    },
    props: {
        id: Number,
        categories_id: Array,
        categories: Array,
        tags_id: Array,
        tags: Array,
        name: String,
        alias: String,
        text: String,
        main_image: String,
        titlePage: String,
        descriptionPage: String,
        keywordsPage: String,
        published: Boolean,
        dateNews: String,
        timeNews: String,
        user: Array,
    },
    data() {
        return {
            editor: ClasicEditor,
            editorConfig: {
                mediaEmbed: {previewsInData: true},
                link: {
                    decorators: {
                        openInNewTab: {
                            mode: 'manual',
                            label: 'Ссылка на другой сайт?',
                            attributes: {
                                target: '_blank',
                                rel: 'nofollow noopener noreferrer'
                            }
                        }
                    }
                }
            },
        }
    },
    methods: {
        /**
         * Сохранение выбранного файла в константу FORM
         * @param form
         */
        uploadLogo(form) {
            // process your files, read as DataUrl or upload...

            //console.log(event.target.files)
            //form.new_logo = event.target.files

            form.image = this.$refs.file.files[0];

            // if you need to re-use field or drop the same files multiple times
            //this.$refs.form.reset()
        },
    },
    mounted(array) {
    },
    setup(props) {
        /**
         * Подготовка массива для выпадающего списка
         */
        function arrayModify(array) {
            let res = []
            if (array != null) {
                array.forEach(function (element, index) {
                    res[index] = {
                        'id': Number(element['id']),
                        'name': element['name']
                    }
                })
            }
            return res
        }

        /**
         * Реактивная формам
         */
        const form = useForm({
            id: props.id,
            categories_id: arrayModify(props.categories_id),
            categories: props.categories,
            tags_id: arrayModify(props.tags_id),
            tags: props.tags,
            name: props.name,
            alias: props.alias,
            text: (props.text != null) ? props.text : '',
            image: '',
            main_image: props.main_image,
            titlePage: props.titlePage,
            descriptionPage: props.descriptionPage,
            keywordsPage: props.keywordsPage,
            published: props.published,
            dateNews: props.dateNews,
            timeNews: props.timeNews,
        })

        /**
         * преобразование значений в bool
         * @type {boolean}
         */
        form.published = getStatus(form.published)

        /**
         * Отправка формы обновления соц. сети
         */
        function updateNews() {
            form.post('/news/update/' + form.id, {
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
                            '<span style="font-size: .90rem">Новость "' + form.name + '" обновлена.</span>')
                    }
                },
            })
        }

        /**
         * Удаление соц. сети
         */
        function deleteNews() {
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
                    form.post('/news/delete/' + props.id, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        // после получения ответа
                        onFinish: visit => {
                            // Показ успешного уведомления
                            Func.Notify(
                                'success',
                                '<span style="font-size: 1.1rem">Успешно!</span>',
                                '<span style="font-size: .90rem">Новость "' + form.name + '" удалена.</span>');
                        },
                    })
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Удаление отменено!",
                        text: "Новость '" + form.name + "' в безопасности :)",
                        icon: "error"
                    });
                }
            });
        }

        /**
         * Получение преобразованного статуса переключателя
         * @param val
         * @returns {boolean}
         */
        function getStatus(val) {
            if (val != 0) {
                return true
            } else {
                return false
            }
        }

        return {form, updateNews, deleteNews, getStatus}
    },
    layout: Layout
}
</script>

<style>
div.p-multiselect-header {
    padding: 5px 15px;
}
ol.p-multiselect-items,
ul.p-multiselect-items {
    margin:  0;
    padding: 5px 0;
}
ol.p-multiselect-items li,
ul.p-multiselect-items li {
    padding: 5px 15px;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>