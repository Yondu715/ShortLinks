FROM nginx:1.27.0 AS base

COPY ./nginx.conf /etc/nginx/nginx.conf
RUN chmod +x /etc/nginx/nginx.conf

COPY ./default.conf.template /etc/nginx/templates/

ENV WEB_USER_ID=1000
ENV WEB_USER_NAME='web'
ENV WEB_GROUP_ID=1000
ENV WEB_GROUP_NAME='web'
RUN echo "Building for web user: id=${WEB_USER_ID} name=${WEB_USER_NAME} group=${WEB_GROUP_NAME}"
RUN groupadd -g ${WEB_GROUP_ID} ${WEB_GROUP_NAME}|| echo "Group exists"
RUN useradd -m -u ${WEB_USER_ID} ${WEB_USER_NAME} -g ${WEB_GROUP_NAME} || echo "Users exists"
RUN sed -i -- "s/user  nginx;/user ${WEB_USER_NAME};/" /etc/nginx/nginx.conf
