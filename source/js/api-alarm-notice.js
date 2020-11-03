class NoticeModule {
    constructor() {
        // this.requestUrl = disturbances.apiUrl + 'wp/v2/disturbances';
        this.requestUrl = 'https://api.helsingborg.se/alarm/json/wp/v2/disturbances';

        this.data = {}

        if (disturbances.places.join(',').length > 0) {
            // this.data.place = disturbances.places.join(',');
        }

        this.getNotices()

        console.log(disturbances)

    }

    getNotices() {
        let dataQuery = this.serialize(this.data);

        async function postData(url = '') {
            const response = await fetch(url, {
                cache: 'no-cache',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer', 
            });

            if(response.status !== 200) {
                return false;
            }
            
            return response.json();
        }
        
        postData(`${this.requestUrl}?${dataQuery}`).then((response) => {
            console.log(response)

            if (disturbances.output_small_active) {
                response.small.forEach(item => {
                    if (document.querySelectorAll('#disturbance-' + item.ID).length > 0) {
                        console.log('Already exists')
                        return;
                    }

                    this.getTemplate(item)

                    document.querySelector(disturbances.output_small).insertAdjacentHTML('afterbegin', this.getTemplate(item));
                });
            }

            if (disturbances.output_big_active) {
                response.big.forEach(item => {
                    if (document.querySelectorAll('#disturbance-' + item.ID).length > 0) {
                        console.log('Already exists')
                        return;
                    }

                    this.getTemplate(item, true)
                    
                    document.querySelector(disturbances.output_big).insertAdjacentHTML('afterbegin', this.getTemplate(item, true));
                });
            }
        })
        .catch((e) => {
            console.log(e)
            console.log('API Alarm Integration plugin: Request failed!');
        });
    }

    serialize(obj) {
        var str = [];
        for (var p in obj)
          if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
          }
        return str.join("&");
    }

    getTemplate(item, big = false,) {
        let size = big ? 'warning' : 'info';

        return '\<div id="disturbance-' + item.ID + '" class="modularity-mod-notices c-notice c-notice--' + size + ' u-margin--0">\
        <span class="c-notice__icon">\<i id="" class="c-icon c-icon--color- c-icon--size-md material-icons" data-uid="5fa0039575fdc">forum\</i>\</span>\<span class="c-notice__message--sm"><strong>' + item.post_title + '\</strong></span></br>' + item.post_content + '\</div>';
    }
}

export default NoticeModule