FROM driftphp/base

WORKDIR /var/www

#
# DriftPHP installation
#
COPY . .

COPY docker/* /

EXPOSE 8000
CMD ["sh", "/server-entrypoint.sh"]
