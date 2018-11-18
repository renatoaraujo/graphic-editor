DOCKER_NETWORK := graphic-editor
DOCKER_APP_IMAGE := graphic-editor-app
DOCKER_APP_RUN := docker run -it --rm --network=$(DOCKER_NETWORK) -p 8080:8080 -v "$(CURDIR)":/graphic-editor -w /graphic-editor $(DOCKER_APP_IMAGE)

setup: network-create build install

network-create:
ifeq ($(strip $(shell docker network list -q --filter name=$(DOCKER_NETWORK))),)
    docker network create $(DOCKER_NETWORK)
endif

build:
	docker build -t $(DOCKER_APP_IMAGE) .

install:
	${DOCKER_APP_RUN} composer install --prefer-dist --optimize-autoloader

run:
	$(DOCKER_APP_RUN) php -S 0.0.0.0:8080 public/index.php
