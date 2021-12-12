@extends('layouts.empty')
@section('main')
    <div class="uk-section uk-section-xsmall">
        <div class="uk-container uk-container-xsmall">
            @include('components.errors')
            <form action="{{ route('partner.interviews.create') }}" method="POST" enctype="multipart/form-data"
                files="true">
                <div class="uk-margin uk-padding uk-border-rounded uk-background-muted">
                    <h1>
                        【ココめぐり】パートナー様向けインタビュー
                    </h1>
                    <div>
                        この度は【ココグルメ】のお取扱いいただき、誠にありがとうございます。
                    </div>
                    <br>
                    <div>
                        弊社では、飼い主様達がもつ【食への関心】をより向上させていくために、
                        皆様へ【ペットの食育】をテーマにインタビューをさせていただいております。
                    </div>
                    <br>
                    <div>
                        お忙しいところお手数お掛けしてしまいますが、ぜひご回答のご協力をいただけますと幸いです。
                        ご回答いただきました内容は、弊社HP【愛犬家たちのコラム】にてご紹介させていただきます。
                    </div>
                    <br>
                    <div>
                        また、SNSアカウントにも順次公開させていただく予定でございます。
                    </div>
                    <br>
                    <div>
                        掲載例<br>
                        <a href="https://coco-gourmet.com/archives/171">https://coco-gourmet.com/archives/171</a><br>
                        <a href="https://coco-gourmet.com/archives/171">https://coco-gourmet.com/archives/182</a><br>
                        <a href="https://coco-gourmet.com/archives/171">https://coco-gourmet.com/archives/206</a><br>
                    </div>
                    <br>
                    どうぞよろしくお願いいたします。
                </div>

                <div class="uk-margin uk-border-rounded uk-padding uk-background-muted">
                    <h3>
                        <span class="uk-text-danger uk-margin-small-right">*</span>御社のお名前を教えてください
                    </h3>
                    <input type="text" class="uk-input" name="partner_name"
                        value="{{ old('partner_name', $partner->name) }}" placeholder="回答を入力">
                </div>

                <div class="uk-margin uk-border-rounded uk-padding uk-background-muted">
                    <h3>
                        <span class="uk-text-danger uk-margin-small-right">*</span>御社の代表者様のお名前を教えてください
                    </h3>
                    <input type="text" class="uk-input" name="representative_name"
                        value="{{ old('representative_name', $partner->staff_name) }}" placeholder="回答を入力">
                </div>

                <div class="uk-margin uk-border-rounded uk-padding uk-background-muted">
                    <h3>
                        <span
                            class="uk-text-danger uk-margin-small-right">*</span>御社の外観やロゴ、ワンちゃん達の画像をご共有ください（可能であれば3枚以上、共有していただけますと幸いです）
                    </h3>
                    <div class="uk-text-small">
                        SNSやブログへの記載内容のサムネイルなどに利用させていただきます。(最大10MB)
                    </div>
                    <div class="uk-margin">
                        <input type="file" name="file[]" multiple><br>
                        <small>※複数選択可能</small>
                    </div>
                </div>

                <div class="uk-margin uk-border-rounded uk-padding uk-background-muted">
                    <h3>
                        <span class="uk-text-danger uk-margin-small-right">*</span>御社の事業について教えて下さい
                    </h3>
                    <div class="uk-text-small">
                        どの様な事業をしているか、事業を進めるにおいての理念や目指しているものを教えてください。(目安200字程度)
                    </div>
                    <textarea class="uk-height-small uk-textarea" name="answer_1" value="{{ old('answer_1') }}"
                        type="text" placeholder="回答を入力"></textarea>
                </div>

                <div class="uk-margin uk-border-rounded uk-padding uk-background-muted">
                    <h3>
                        <span class="uk-text-danger uk-margin-small-right">*</span>創業経緯を教えてください
                    </h3>
                    <div class="uk-text-small">
                        今までのご経歴や御社を創業するきっかけを教えてください。(目安300字程度)
                    </div>
                    <textarea class="uk-height-small uk-textarea" name="answer_2" value="{{ old('answer_2') }}"
                        type="text" placeholder="回答を入力"></textarea>
                </div>

                <div class="uk-margin uk-border-rounded uk-padding uk-background-muted">
                    <h3>
                        <span class="uk-text-danger uk-margin-small-right">*</span>御社から見た「ペットの食育」についてのお考えをお聞かせください
                    </h3>
                    <div class="uk-text-small">
                        ペットと関わるなかで「食事」や「食事を通した体験」について理念やお考えや、「飼い主さんに知っておいて欲しい食事に関すること」があればお聞かせください。(目安400-500字程度)
                    </div>
                    <textarea class="uk-height-small uk-textarea" name="answer_3" value="{{ old('answer_3') }}"
                        type="text" placeholder="回答を入力"></textarea>
                </div>

                <div class="uk-margin uk-border-rounded uk-padding uk-background-muted">
                    <h3>
                        <span class="uk-text-danger uk-margin-small-right">*</span>「ココグルメ」を取り扱っていただくことについてお聞かせください
                    </h3>
                    <div class="uk-text-small">
                        ココグルメを取扱って頂くことになった経緯や、ココグルメの魅力、どんなお客さんにおすすめしたいか？をお聞かせください。(目安400-500字程度)
                    </div>
                    <textarea class="uk-height-small uk-textarea" name="answer_4" value="{{ old('answer_4') }}"
                        type="text" placeholder="回答を入力"></textarea>
                </div>
                <div class="uk-margin uk-text-center">
                    <button class="uk-width-medium@s uk-button uk-button-primary">回答を送信</button>
                </div>
                <input type="hidden" name="question_1" value="事業について。理念や目指しているもの">
                <input type="hidden" name="question_2" value="創業のきっかけ">
                <input type="hidden" name="question_3" value="食育について">
                <input type="hidden" name="question_4" value="ココグルメを取り扱う経緯。どんな人に進めたいか">
                <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                @csrf
            </form>
        </div>
    </div>
@endsection
