function showModal(message, redirectUrl) {
    // 기존에 모달이 열려 있다면 닫기
    var existingModal = document.getElementById('myModal');
    if (existingModal) {
        document.body.removeChild(existingModal);
    }

    // 모달 요소 생성
    var modal = document.createElement('div');
    modal.className = 'modal';
    modal.id = 'myModal';
    
    var modalContent = document.createElement('div');
    modalContent.className = 'modal-content';

    var closeButton = document.createElement('span');
    closeButton.className = 'close';
    closeButton.innerHTML = '&times;';

    var messageParagraph = document.createElement('p');
    messageParagraph.textContent = message;

    // 모달 내용 추가
    modalContent.appendChild(closeButton);
    modalContent.appendChild(messageParagraph);
    modal.appendChild(modalContent);
    document.body.appendChild(modal);

    // 모달 스타일링을 위한 CSS 추가
    var css = `
        .modal {
            display: block;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    `;
    var style = document.createElement('style');
    style.type = 'text/css';
    style.appendChild(document.createTextNode(css));
    document.head.appendChild(style);

    // 모달 닫기 이벤트
    closeButton.onclick = function() {
        modal.style.display = 'none';
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            if (redirectUrl) {
                window.location.href = redirectUrl;
            }
        }
    }
}
