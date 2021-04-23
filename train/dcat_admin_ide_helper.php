<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection width
     * @property Grid\Column|Collection judgment
     * @property Grid\Column|Collection single
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection member_type
     * @property Grid\Column|Collection company_name
     * @property Grid\Column|Collection social_code
     * @property Grid\Column|Collection province
     * @property Grid\Column|Collection city
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection legal_person
     * @property Grid\Column|Collection legal_person_id_card
     * @property Grid\Column|Collection contact_name
     * @property Grid\Column|Collection contact_phone
     * @property Grid\Column|Collection payee
     * @property Grid\Column|Collection bank
     * @property Grid\Column|Collection bank_address
     * @property Grid\Column|Collection bank_account
     * @property Grid\Column|Collection bank_account_confirmation
     * @property Grid\Column|Collection business_picture
     * @property Grid\Column|Collection bank_permit_picture
     * @property Grid\Column|Collection is_permit
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection position
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection nick_name
     * @property Grid\Column|Collection sex
     * @property Grid\Column|Collection birthday
     * @property Grid\Column|Collection attribute
     * @property Grid\Column|Collection mechanism_id
     * @property Grid\Column|Collection industry_id
     * @property Grid\Column|Collection occupation_id
     * @property Grid\Column|Collection api_token
     * @property Grid\Column|Collection score
     * @property Grid\Column|Collection question_count
     * @property Grid\Column|Collection exam_id
     * @property Grid\Column|Collection question_id
     * @property Grid\Column|Collection sort
     * @property Grid\Column|Collection href_way
     * @property Grid\Column|Collection material_id
     * @property Grid\Column|Collection link
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection learning_material_id
     * @property Grid\Column|Collection chapter_id
     * @property Grid\Column|Collection is_open
     * @property Grid\Column|Collection video
     * @property Grid\Column|Collection duration
     * @property Grid\Column|Collection learning_material_detail_id
     * @property Grid\Column|Collection picture
     * @property Grid\Column|Collection social_credit_code
     * @property Grid\Column|Collection deposit_bank
     * @property Grid\Column|Collection bank_card_number
     * @property Grid\Column|Collection id_card
     * @property Grid\Column|Collection choice_question_num
     * @property Grid\Column|Collection choice_question_score
     * @property Grid\Column|Collection judgment_question_num
     * @property Grid\Column|Collection judgment_question_score
     * @property Grid\Column|Collection exam_time
     * @property Grid\Column|Collection passing_grade
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection lng
     * @property Grid\Column|Collection lat
     * @property Grid\Column|Collection material_ids
     * @property Grid\Column|Collection attributes
     * @property Grid\Column|Collection description_image
     * @property Grid\Column|Collection answer_single_option
     * @property Grid\Column|Collection answer_judgment_option
     * @property Grid\Column|Collection true_single_answer
     * @property Grid\Column|Collection true_judgment_answer
     * @property Grid\Column|Collection md5
     * @property Grid\Column|Collection download_link
     * @property Grid\Column|Collection after_version
     * @property Grid\Column|Collection before_version
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection os
     * @property Grid\Column|Collection version_code
     *
     * @method Grid\Column|Collection width(string $label = null)
     * @method Grid\Column|Collection judgment(string $label = null)
     * @method Grid\Column|Collection single(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection member_type(string $label = null)
     * @method Grid\Column|Collection company_name(string $label = null)
     * @method Grid\Column|Collection social_code(string $label = null)
     * @method Grid\Column|Collection province(string $label = null)
     * @method Grid\Column|Collection city(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection legal_person(string $label = null)
     * @method Grid\Column|Collection legal_person_id_card(string $label = null)
     * @method Grid\Column|Collection contact_name(string $label = null)
     * @method Grid\Column|Collection contact_phone(string $label = null)
     * @method Grid\Column|Collection payee(string $label = null)
     * @method Grid\Column|Collection bank(string $label = null)
     * @method Grid\Column|Collection bank_address(string $label = null)
     * @method Grid\Column|Collection bank_account(string $label = null)
     * @method Grid\Column|Collection bank_account_confirmation(string $label = null)
     * @method Grid\Column|Collection business_picture(string $label = null)
     * @method Grid\Column|Collection bank_permit_picture(string $label = null)
     * @method Grid\Column|Collection is_permit(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection position(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection nick_name(string $label = null)
     * @method Grid\Column|Collection sex(string $label = null)
     * @method Grid\Column|Collection birthday(string $label = null)
     * @method Grid\Column|Collection attribute(string $label = null)
     * @method Grid\Column|Collection mechanism_id(string $label = null)
     * @method Grid\Column|Collection industry_id(string $label = null)
     * @method Grid\Column|Collection occupation_id(string $label = null)
     * @method Grid\Column|Collection api_token(string $label = null)
     * @method Grid\Column|Collection score(string $label = null)
     * @method Grid\Column|Collection question_count(string $label = null)
     * @method Grid\Column|Collection exam_id(string $label = null)
     * @method Grid\Column|Collection question_id(string $label = null)
     * @method Grid\Column|Collection sort(string $label = null)
     * @method Grid\Column|Collection href_way(string $label = null)
     * @method Grid\Column|Collection material_id(string $label = null)
     * @method Grid\Column|Collection link(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection learning_material_id(string $label = null)
     * @method Grid\Column|Collection chapter_id(string $label = null)
     * @method Grid\Column|Collection is_open(string $label = null)
     * @method Grid\Column|Collection video(string $label = null)
     * @method Grid\Column|Collection duration(string $label = null)
     * @method Grid\Column|Collection learning_material_detail_id(string $label = null)
     * @method Grid\Column|Collection picture(string $label = null)
     * @method Grid\Column|Collection social_credit_code(string $label = null)
     * @method Grid\Column|Collection deposit_bank(string $label = null)
     * @method Grid\Column|Collection bank_card_number(string $label = null)
     * @method Grid\Column|Collection id_card(string $label = null)
     * @method Grid\Column|Collection choice_question_num(string $label = null)
     * @method Grid\Column|Collection choice_question_score(string $label = null)
     * @method Grid\Column|Collection judgment_question_num(string $label = null)
     * @method Grid\Column|Collection judgment_question_score(string $label = null)
     * @method Grid\Column|Collection exam_time(string $label = null)
     * @method Grid\Column|Collection passing_grade(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection lng(string $label = null)
     * @method Grid\Column|Collection lat(string $label = null)
     * @method Grid\Column|Collection material_ids(string $label = null)
     * @method Grid\Column|Collection attributes(string $label = null)
     * @method Grid\Column|Collection description_image(string $label = null)
     * @method Grid\Column|Collection answer_single_option(string $label = null)
     * @method Grid\Column|Collection answer_judgment_option(string $label = null)
     * @method Grid\Column|Collection true_single_answer(string $label = null)
     * @method Grid\Column|Collection true_judgment_answer(string $label = null)
     * @method Grid\Column|Collection md5(string $label = null)
     * @method Grid\Column|Collection download_link(string $label = null)
     * @method Grid\Column|Collection after_version(string $label = null)
     * @method Grid\Column|Collection before_version(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection os(string $label = null)
     * @method Grid\Column|Collection version_code(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection width
     * @property Show\Field|Collection judgment
     * @property Show\Field|Collection single
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection member_type
     * @property Show\Field|Collection company_name
     * @property Show\Field|Collection social_code
     * @property Show\Field|Collection province
     * @property Show\Field|Collection city
     * @property Show\Field|Collection address
     * @property Show\Field|Collection legal_person
     * @property Show\Field|Collection legal_person_id_card
     * @property Show\Field|Collection contact_name
     * @property Show\Field|Collection contact_phone
     * @property Show\Field|Collection payee
     * @property Show\Field|Collection bank
     * @property Show\Field|Collection bank_address
     * @property Show\Field|Collection bank_account
     * @property Show\Field|Collection bank_account_confirmation
     * @property Show\Field|Collection business_picture
     * @property Show\Field|Collection bank_permit_picture
     * @property Show\Field|Collection is_permit
     * @property Show\Field|Collection status
     * @property Show\Field|Collection position
     * @property Show\Field|Collection content
     * @property Show\Field|Collection nick_name
     * @property Show\Field|Collection sex
     * @property Show\Field|Collection birthday
     * @property Show\Field|Collection attribute
     * @property Show\Field|Collection mechanism_id
     * @property Show\Field|Collection industry_id
     * @property Show\Field|Collection occupation_id
     * @property Show\Field|Collection api_token
     * @property Show\Field|Collection score
     * @property Show\Field|Collection question_count
     * @property Show\Field|Collection exam_id
     * @property Show\Field|Collection question_id
     * @property Show\Field|Collection sort
     * @property Show\Field|Collection href_way
     * @property Show\Field|Collection material_id
     * @property Show\Field|Collection link
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection learning_material_id
     * @property Show\Field|Collection chapter_id
     * @property Show\Field|Collection is_open
     * @property Show\Field|Collection video
     * @property Show\Field|Collection duration
     * @property Show\Field|Collection learning_material_detail_id
     * @property Show\Field|Collection picture
     * @property Show\Field|Collection social_credit_code
     * @property Show\Field|Collection deposit_bank
     * @property Show\Field|Collection bank_card_number
     * @property Show\Field|Collection id_card
     * @property Show\Field|Collection choice_question_num
     * @property Show\Field|Collection choice_question_score
     * @property Show\Field|Collection judgment_question_num
     * @property Show\Field|Collection judgment_question_score
     * @property Show\Field|Collection exam_time
     * @property Show\Field|Collection passing_grade
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection lng
     * @property Show\Field|Collection lat
     * @property Show\Field|Collection material_ids
     * @property Show\Field|Collection attributes
     * @property Show\Field|Collection description_image
     * @property Show\Field|Collection answer_single_option
     * @property Show\Field|Collection answer_judgment_option
     * @property Show\Field|Collection true_single_answer
     * @property Show\Field|Collection true_judgment_answer
     * @property Show\Field|Collection md5
     * @property Show\Field|Collection download_link
     * @property Show\Field|Collection after_version
     * @property Show\Field|Collection before_version
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection os
     * @property Show\Field|Collection version_code
     *
     * @method Show\Field|Collection width(string $label = null)
     * @method Show\Field|Collection judgment(string $label = null)
     * @method Show\Field|Collection single(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection member_type(string $label = null)
     * @method Show\Field|Collection company_name(string $label = null)
     * @method Show\Field|Collection social_code(string $label = null)
     * @method Show\Field|Collection province(string $label = null)
     * @method Show\Field|Collection city(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection legal_person(string $label = null)
     * @method Show\Field|Collection legal_person_id_card(string $label = null)
     * @method Show\Field|Collection contact_name(string $label = null)
     * @method Show\Field|Collection contact_phone(string $label = null)
     * @method Show\Field|Collection payee(string $label = null)
     * @method Show\Field|Collection bank(string $label = null)
     * @method Show\Field|Collection bank_address(string $label = null)
     * @method Show\Field|Collection bank_account(string $label = null)
     * @method Show\Field|Collection bank_account_confirmation(string $label = null)
     * @method Show\Field|Collection business_picture(string $label = null)
     * @method Show\Field|Collection bank_permit_picture(string $label = null)
     * @method Show\Field|Collection is_permit(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection position(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection nick_name(string $label = null)
     * @method Show\Field|Collection sex(string $label = null)
     * @method Show\Field|Collection birthday(string $label = null)
     * @method Show\Field|Collection attribute(string $label = null)
     * @method Show\Field|Collection mechanism_id(string $label = null)
     * @method Show\Field|Collection industry_id(string $label = null)
     * @method Show\Field|Collection occupation_id(string $label = null)
     * @method Show\Field|Collection api_token(string $label = null)
     * @method Show\Field|Collection score(string $label = null)
     * @method Show\Field|Collection question_count(string $label = null)
     * @method Show\Field|Collection exam_id(string $label = null)
     * @method Show\Field|Collection question_id(string $label = null)
     * @method Show\Field|Collection sort(string $label = null)
     * @method Show\Field|Collection href_way(string $label = null)
     * @method Show\Field|Collection material_id(string $label = null)
     * @method Show\Field|Collection link(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection learning_material_id(string $label = null)
     * @method Show\Field|Collection chapter_id(string $label = null)
     * @method Show\Field|Collection is_open(string $label = null)
     * @method Show\Field|Collection video(string $label = null)
     * @method Show\Field|Collection duration(string $label = null)
     * @method Show\Field|Collection learning_material_detail_id(string $label = null)
     * @method Show\Field|Collection picture(string $label = null)
     * @method Show\Field|Collection social_credit_code(string $label = null)
     * @method Show\Field|Collection deposit_bank(string $label = null)
     * @method Show\Field|Collection bank_card_number(string $label = null)
     * @method Show\Field|Collection id_card(string $label = null)
     * @method Show\Field|Collection choice_question_num(string $label = null)
     * @method Show\Field|Collection choice_question_score(string $label = null)
     * @method Show\Field|Collection judgment_question_num(string $label = null)
     * @method Show\Field|Collection judgment_question_score(string $label = null)
     * @method Show\Field|Collection exam_time(string $label = null)
     * @method Show\Field|Collection passing_grade(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection lng(string $label = null)
     * @method Show\Field|Collection lat(string $label = null)
     * @method Show\Field|Collection material_ids(string $label = null)
     * @method Show\Field|Collection attributes(string $label = null)
     * @method Show\Field|Collection description_image(string $label = null)
     * @method Show\Field|Collection answer_single_option(string $label = null)
     * @method Show\Field|Collection answer_judgment_option(string $label = null)
     * @method Show\Field|Collection true_single_answer(string $label = null)
     * @method Show\Field|Collection true_judgment_answer(string $label = null)
     * @method Show\Field|Collection md5(string $label = null)
     * @method Show\Field|Collection download_link(string $label = null)
     * @method Show\Field|Collection after_version(string $label = null)
     * @method Show\Field|Collection before_version(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection os(string $label = null)
     * @method Show\Field|Collection version_code(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
