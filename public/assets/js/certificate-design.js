$(document).ready(function () {
            // Background Image
            $('#backgroundImage').change(function () {
                var file = $(this)[0].files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#certificate').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(file);
            });

            // Additional Image
            $('#additionalImage').on("change",function () {
                var file = $('#additionalImage')[0].files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    var image = $('<img>').attr('src', e.target.result).addClass('draggable');
                    image.css({
                        width: 300 + 'px',
                        height: 'auto'
                    });
                    $('#certificate').append(image);
                };
                reader.readAsDataURL(file);
            });

            // Add Text
            $('#addText').click(function () {
                var text = $('#text').val();
                var fontSize = $('#fontSize').val();
                var fontWeight = $('#fontWeight').val();
                var fontStyle = $('#fontStyle').val();
                var fontFamily = $('#fontFamily').val();

                var textElement = $('<p>').text(text).addClass('draggable');
                textElement.css({
                    'font-size': fontSize + 'px',
                    'font-weight': fontWeight,
                    'font-style': fontStyle,
                    'font-family': fontFamily
                });
                $('#certificate').append(textElement);
            });

            // Save Certificate
            $('#saveCertificate').click(function () {
                html2canvas($('#certificate')[0]).then(function (canvas) {
                    canvas.toBlob(function (blob) {
                        saveAs(blob, 'certificate.png');
                    });
                });
            });
            // Make elements interactable (draggable, resizable, rotatable)
            function makeInteractable(element) {
                interact(element[0])
                    .draggable({
                        onmove: function (event) {
                            var target = event.target;
                            var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                            var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                            target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                            target.setAttribute('data-x', x);
                            target.setAttribute('data-y', y);
                        }
                    })
                    .resizable({
                        edges: {
                            left: true,
                            right: true,
                            bottom: true,
                            top: true
                        }
                    })
                    .on('resizemove', function (event) {
                        var target = event.target;
                        var x = parseFloat(target.getAttribute('data-x')) || 0;
                        var y = parseFloat(target.getAttribute('data-y')) || 0;

                        target.style.width = event.rect.width + 'px';
                        target.style.height = event.rect.height + 'px';

                        x += event.deltaRect.left;
                        y += event.deltaRect.top;

                        target.style.transform = 'translate(' + x + 'px,' + y + 'px)';
                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);
                    })
                    .rotatable();

                element.draggable("option", "containment", "#certificate");
                element.resizable("option", "containment", "#certificate");
            }


            $('#certificate').contextMenu({
                selector: '.draggable',
                trigger: 'right',
                autoHide: true,
                items: {
                    remove: {
                        name: 'Remove',
                        callback: function(event, options) {
                            options.$trigger.parent().remove();
                        }
                    },
                    move: {
                        name: 'Move',
                        callback: function(event, options) {
                            interact(options.$trigger[0]).draggable({
                                onmove: function (event) {
                                    var target = event.target;
                                    var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                                    var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                                    target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                                    target.setAttribute('data-x', x);
                                    target.setAttribute('data-y', y);
                                }
                            })
                        }
                    },
                    resize: {
                        name: 'Resize',
                        callback: function(event, options) {
                            interact(options.$trigger[0]).resizable({
                                edges: {
                                    left: true,
                                    right: true,
                                    bottom: true,
                                    top: true
                                },squareResize: true,
                            }).on('resizemove', function (event) {
                                var target = event.target;
                                var x = parseFloat(target.getAttribute('data-x')) || 0;
                                var y = parseFloat(target.getAttribute('data-y')) || 0;

                                var aspectRatio = target.offsetWidth / target.offsetHeight;

                                var newWidth = event.rect.width;
                                var newHeight = newWidth / aspectRatio;

                                if (event.edges.top || event.edges.bottom) {
                                    newHeight = event.rect.height;
                                    newWidth = newHeight * aspectRatio;
                                }
                                
                                target.style.width = event.rect.width + 'px';
                                target.style.height = event.rect.height + 'px';

                                x += event.deltaRect.left;
                                y += event.deltaRect.top;

                                target.style.transform = 'translate(' + x + 'px,' + y + 'px)';
                                target.setAttribute('data-x', x);
                                target.setAttribute('data-y', y);
                            })
                        }
                    },
                    rotate: {
                        name: 'Rotate',
                        callback: function(event, options) {
                            
                        }
                    },
                }
            });
            
            $("[targetClick]").on("click",function(){
                $($(this).attr('targetClick')).click();
            })
        });