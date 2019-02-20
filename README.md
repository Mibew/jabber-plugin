# Mibew Jabber plugin
Plugin for Mibew Messenger to send notifications on new chats into Jabber (by XMPP).

# Install

1. Get the archive with the plugin sources. You can download it from the [official site](https://mibew.org/plugins#mibew-jabber) or build the plugin from sources.
2. Untar/unzip the plugin's archive.
3. Put files of the plugins to the `<MIBEW-ROOT>/plugins` folder.
4. Configure the plugin by altering the section ```plugins``` in "`<Mibew root>`/configs/config.yml" file.

If the "plugins" structure looks like `plugins: []` it will become:

```yaml
    plugins:
        "Mibew:Jabber": # Plugin's configurations are described below
            server: "tcp://example.com:5222"
            username: "account@example.com/MibewMessenger"
            password: "password"
            rcpt: "jid@example.com"
```
or (if you want to send notifications to multiple users):

```yaml
    plugins:
        "Mibew:Jabber": # Plugin's configurations are described below
            server: "tcp://example.com:5222"
            username: "account@example.com/MibewMessenger"
            password: "password"
            rcpt: ["jid1@example.com", "jid2@example.com"]
```

5. Navigate to `<MIBEW-BASE-URL>/operator/plugin` page and enable the plugin.

## Plugin's configurations

The plugin can be configured with values in "`<Mibew root>`/configs/config.yml"
file.

### config.server

Type: `String`

Address of your XMPP (Jabber) server. Should be written as `<proto>://<server address>:<port>`.

### config.username

Type: `String`

The username (JID) of your notification bot. Could be written as `JID/Resource`.

### config.password

Type: `String`

The password of bot XMPP account.

### config.rcpt

Type: `String` or `Array`

JID or JIDs to send notifications to.

# Build from sources

1. Obtain a copy of the repository using `git clone`, download button, or another way.
2. Install [node.js](http://nodejs.org/) and [npm](https://www.npmjs.org/).
3. Install [Gulp](http://gulpjs.com/).
4. Install npm dependencies using `npm install`.
5. Run Gulp to build the sources using `gulp default`.

Finally `.tar.gz` and `.zip` archives of the ready-to-use Plugin will be available in release directory.

# License

[Apache License 2.0](http://www.apache.org/licenses/LICENSE-2.0.html)
